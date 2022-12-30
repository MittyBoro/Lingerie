<?php

namespace App\Services\SpatieMedia;

use Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait InteractsWithCustomMedia
{
    use InteractsWithMedia;

    private $collectionsWithDeletingOriginal = [];

    public function syncMedia($data, $collectionName = 'default', $diskName = ''): Collection
    {
        $collect = collect($data)->filter(function ($value) {
            return !isset($value['del']);
        })->values();

        $collect = $collect->map(function($item, $order) use ($collectionName, $diskName) {
            $media = $this->syncSingleMedia($item, $collectionName, $diskName);

            if (!$media->id)
                return false;

            if ($media->order_column != $order) {
                $media->order_column = $order;
                $media->save();
            }

            return $media;
        });

        $this->clearMediaCollectionExcept($collectionName, $collect);

        return $collect;
    }

    public function syncSingleMedia(array $singleMedia, $collectionName = 'default', $diskName = ''): Media
    {
        if (Arr::hasAny($singleMedia, ['file', 'path', 'url'])) {
            $mediaModel = $this->addSingleMedia($singleMedia, $collectionName, $diskName);
        }
        elseif ( isset($singleMedia['id']) ) {
            $mediaModel = Media::find($singleMedia['id']);
        }
        else {
            throw new \Exception('Undefinded $singleMedia values');
        }

        return $mediaModel;
    }

    public function addSingleMedia($singleMedia, $collectionName = 'default', $diskName = ''): Media
    {
        if ( isset($singleMedia['file']) ) {
            $mediaModel = $this
                        ->addMedia($singleMedia['file']);
        }
        elseif ( isset($singleMedia['url']) ) {
            try {
                $mediaModel = $this
                            ->addMediaFromUrl($singleMedia['url']);
            } catch (\Throwable $th) {
                \Log::error($th);
                return new Media;
            }
        }
        elseif ( isset($singleMedia['path']) ) {
            $mediaModel = $this
                        ->addMediaFromDisk($singleMedia['path'], $singleMedia['disk'] ?? null );
        }
        else {
            throw new \Exception('Undefinded $singleMedia key');
        }



        $mediaModel = $mediaModel->sanitizingFileName(function($fileName) {
                                return rename_file($fileName);
                            })
                            ->toMediaCollection($collectionName, $diskName);

        $this->removeOriginalMedia($mediaModel);

        return $mediaModel;

    }

    private function removeOriginalMedia($mediaModel)
    {
        if (!method_exists($this, 'registerMediaCollectionsWithDeletingOriginal'))
            return;

        $collections = $this->registerMediaCollectionsWithDeletingOriginal();

        foreach($collections as $collection_name) {

            if ($collection_name != $mediaModel->collection_name )
                continue;

            $disk = $mediaModel->disk;
            $relativePath = $this->getRelativePath($mediaModel);

            Storage::disk($disk)->delete($relativePath);
        }
    }

    private function getRelativePath(Media $media, string $conversionName = '')
    {
        $relativePath = $media->getPath($conversionName);

        if ($rootPath = config("filesystems.disks.{$media->disk}.root")) {
            $relativePath = str_replace($rootPath, '', $relativePath);
        }

        return $relativePath;
    }


    public function getAdminMedia(string $collectionName = 'default', string $conversion = '', array|callable $filters = [])
    {
        return $this->getMedia($collectionName, $filters)
                    ->map(function($singleMedia) use ($conversion) {
                        $data = [
                            'id' => $singleMedia->id,
                            'url' =>$singleMedia->getFullUrl($conversion),
                            'name' => $singleMedia->file_name,
                            'collection_name' => $singleMedia->collection_name,
                            'size' => $singleMedia->size,
                            'custom' => $singleMedia->custom_properties,
                        ];

                        return $data;
                    });
    }

    public function getMediaUrlsConversions(string $collectionName = 'default', array $sizes = ['original'])
    {
        $media = $this->getMedia($collectionName)->map(function($item) use ($sizes) {
            foreach($sizes as $s) {
                if ($s == 'original')
                    $s = '';

                $urls[$s] = $item->getFullUrl( $s );
            }

            return collect($urls);
        });

        return $media;
    }

    public function getMediaUrls(string $collectionName = 'default', string $conversion = '')
    {
        $media = $this->getMedia($collectionName)->map(function($item) use ($conversion) {
            return $item->getFullUrl($conversion);
        });
        return $media;
    }

}
