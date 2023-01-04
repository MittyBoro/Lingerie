<?php

namespace App\Models;

use App\Models\Product\Product;
use Spatie\MediaLibrary\HasMedia;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Prop extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;

    public $timestamps = false;

    const MEDIA_COLLECTION = 'main';

    protected $hidden = [
        'value_string',
        'value_text',
    ];

    protected $appends = [
        'value',
    ];

    const ALLOWED_MODELS = [
        'pages'    => Page::class,
        'posts'    => Post::class,
        'products' => Product::class,
    ];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION);
    }

    public function model()
    {
        return $this->morphTo('model');
    }

    public function getModelNameAttribute()
    {
        if (!$this->model_type)
            return;
        return Str::snake(Str::pluralStudly(class_basename($this->model_type)));
    }

    public function setModelTypeAttribute($val)
    {
        if ( !in_array($val, array_keys(self::ALLOWED_MODELS)) ) {
            $this->attributes['model_type'] = class_exists($val) ? $val : null;
        } else {
            $this->attributes['model_type'] = self::ALLOWED_MODELS[$val];
        }
    }

    public function getValueAttribute()
    {
        if ( $this->attributes['type'] == 'string' )
            return $this->value_string;
        elseif ( $this->attributes['type'] == 'boolean' )
            return (bool)$this->value_string;
        elseif ( $this->attributes['type'] == 'file' )
            return $this->file;
        elseif ( $this->attributes['type'] == 'files' )
            return $this->files;
        elseif ( $this->attributes['type'] == 'text_array' )
            return text_to_array($this->value_text);
        else
            return $this->value_text;
    }


    public function getFileAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION);
    }
    public function getFilesAttribute()
    {
        return $this->getMedia(self::MEDIA_COLLECTION)?->map->getFullUrl();
    }

    public function getFilePathAttribute()
    {
        return $this->getFirstMedia(self::MEDIA_COLLECTION)?->getPath();
    }
    public function getFilesPathAttribute()
    {
        return $this->getMedia(self::MEDIA_COLLECTION)?->map->getPath();
    }

    public static function manyByKey($key, $raw = false)
    {
        if (!is_array($key))
            $key = [$key];

        $result = self::select('id','type', 'key', 'value_string', 'value_text')
                    ->with('media')
                    ->whereIn('key', $key)
                    ->get()
                    ->keyBy('key');

        if ($raw) {
            return $result;
        }

        return $result
                ?->map(function($item) {
                    return $item->value;
                });
    }

    public static function byKey($key, $raw = false)
    {
        return self::manyByKey($key, $raw)->first() ?? null;
    }

    public function scopeList(Builder $query, $model_type = null, $model_id = null)
    {
        $query
            ->select('id','type', 'key', 'value_string', 'value_text')
            ->with('media');

        if ($model_type)
            $query->whereHasMorph('model', $model_type, fn($q) => $q->where('model_id', $model_id));
        else
            $query->whereNull('model_type');


        return $query
                ->get()
                ->keyBy('key')
                ->map(function($item) {
                    return $item->value;
                });
    }


}
