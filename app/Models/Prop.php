<?php

namespace App\Models;

use App\Models\Product\Product;
use Spatie\MediaLibrary\HasMedia;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Manipulations;

class Prop extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;

    public $timestamps = false;

    const DEFAULT_TAB = 'Основное';

    const MEDIA_COLLECTION_FILE = 'file';
    const MEDIA_COLLECTION_IMAGE = 'image';


    const MODELS = [
        'pages'    => \App\Models\Page::class,
        'products' => \App\Models\Product::class,
    ];

    const TYPES = [
        'string'      => 'Строка',
        'text'        => 'Текст',
        'format_text' => 'Форматируемый текст',
        'text_array'  => 'Текстовый массив',
        'boolean'     => 'Выключатель',
        'file'        => 'Файл',
        'files'       => 'Файлы',
        'image'        => 'Изображение',
        'images'       => 'Изображения',
    ];

    protected $fillable = [
        'tab',
        'model_type',
        'model_id',
        'type',
        'key',
        'title',
        'value_string',
        'value_text',
        'value',
        'position'
    ];

    protected $hidden = [
        'value_string',
        'value_text',
        'media',
    ];

    protected $appends = [
        'value',
    ];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION_FILE);
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION_IMAGE)
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 400, 400);
                $this
                    ->addMediaConversion('medium')
                    ->fit(Manipulations::FIT_CROP, 640, 640);
                $this
                    ->addMediaConversion('big')
                    ->fit(Manipulations::FIT_MAX, 1280, 1280);
            });
    }

    public function model()
    {
        return $this->morphTo('model');
    }

    public function getValueAttribute()
    {
        $type = $this->attributes['type'];

        if ( $type == 'string' )
            return $this->value_string;
        elseif ( $type == 'boolean' )
            return (bool)$this->value_string;
        elseif ( $type == 'file' )
            return $this->file;
        elseif ( $type == 'files' )
            return $this->files;
        elseif ( $type == 'image' )
            return $this->image;
        elseif ( $type == 'images' )
            return $this->images;
        elseif ( $type == 'text_array' )
            return $this->text_array;
        else
            return $this->value_text;
    }

    public function getFileAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_FILE);
    }
    public function getFilesAttribute()
    {
        return $this->getMedia(self::MEDIA_COLLECTION_FILE)?->map->getFullUrl();
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_IMAGE);
    }
    public function getImagesAttribute()
    {
        return $this->getMedia(self::MEDIA_COLLECTION_IMAGE)?->map->getFullUrl();
    }
    public function getTextArrayAttribute()
    {
        return json_decode($this->value_text);
    }


    public function scopeQueryByKeys(Builder $query, string|array $keys)
    {
        $keys = is_string($keys) ?  explode(',', $keys) : $keys;

        return $query
                ->select('id','type', 'key', 'value_string', 'value_text')
                ->with('media')
                ->whereIn('key', $keys);
    }
    public function scopeQueryByModel(Builder $query, Model $model = null)
    {
        if ($model) {
            return $query->where([
                    ['model_type', $model::class],
                    ['model_id', $model->id],
                ]);
        }

        return $query
                ->whereNull('model_type')
                ->whereNull('model_id');
    }

    public static function findByKey(string $key, Model $model = null)
    {
        return self::queryByKeys($key)
                   ->queryByModel($model)
                   ->first()
                   ?->value;
    }

    public static function list(Model $model = null)
    {
        return self::queryByModel($model)
                   ->get()
                   ->keyBy('key')
                   ->map(fn($m) => $m->value);
    }

    public static function getByKeys($keys, Model $model = null)
    {
        $keys = (array) $keys;

        $data = self::queryByKeys($keys)
                    ->queryByModel($model)
                    ->get()
                    ->keyBy('key')
                    ->map(fn($m) => $m->value);

        foreach($keys as $key) {
            if ( !$data->has($key) ) {
                $data->put($key, null);
            }
        }

        return $data;
    }


}
