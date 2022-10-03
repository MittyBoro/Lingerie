<?php

namespace App\Services\SpatieMedia;

use Illuminate\Support\Str;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MyPathGenerator implements PathGenerator
{
	/*
	* Get the path for the given media, relative to the root storage path.
	*/
	public function getPath(Media $media): string
	{
		return $this->getBasePath($media).'/';
	}

	/*
	* Get the path for conversions of the given media, relative to the root storage path.
	*/
	public function getPathForConversions(Media $media): string
	{
		return $this->getBasePath($media).'/';
	}

	/*
	* Get the path for responsive images of the given media, relative to the root storage path.
	*/
	public function getPathForResponsiveImages(Media $media): string
	{
		return $this->getBasePath($media).'/';
	}

	/*
	* Get a unique base path for the given media.
	*/
	protected function getBasePath(Media $media): string
	{
        $prefix = config('media-library.prefix', '');

		$modelName = Str::snake(Str::pluralStudly(class_basename($media->model_type)));
		$folder = $prefix . $modelName . '/' . $media->collection_name. '/';

		if ($media->getCustomProperty('folder')) {
			$folder = $media->getCustomProperty('folder') . '/';
		}

		return $folder . $media->getKey();
	}
}
