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

    const MEDIA_COLLECTION_FILE = 'file';
    const MEDIA_COLLECTION_IMAGE = 'image';

    protected $fillable = [
        'tab',
        'model_type',
        'model_id',
        'type',
        'key',
        'title',
        'value_string',
        'value_text',
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
            ->addMediaCollection(self::MEDIA_COLLECTION_IMAGE);
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
        elseif ( $this->attributes['type'] == 'image' )
            return $this->image;
        elseif ( $this->attributes['type'] == 'images' )
            return $this->images;
        elseif ( $this->attributes['type'] == 'text_array' )
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
    public function getTextArrayAttribute()
    {
        return text_to_array($this->value_text);
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
