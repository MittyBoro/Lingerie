<?php

namespace App\Models;

use App\Models\Product\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Prop extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;

    protected $guarded = ['admin_value', 'value'];

    public $timestamps = false;
    const MEDIA_COLLECTION = 'main';

    const DEFAULT_TAB = 'Основное';

    const TYPES = [
        'string'      => 'Строка',
        'text'        => 'Текст',
        'format_text' => 'Форматируемый текст',
        'text_array'  => 'Текстовый массив',
        'boolean'     => 'Выключатель',
        'file'        => 'Файл',
        'files'       => 'Файлы',
    ];

    const ALLOWED_MODELS = [
        'pages'    => Page::class,
        'posts'    => Post::class,
        'products' => Product::class,
    ];

    protected $hidden = [
        'value_string',
        'value_text',
    ];

    protected $appends = [
        'value',
    ];

    protected $orderBy = ['position', 'asc'];
    protected $orderFileds = [
        'id',
        'tab',
        'key',
        'title',
        'type',
        'model_type',
    ];


    public static function boot()
    {
        parent::boot();

        static::creating( function($model)
        {
            $model->position = self::max('position') + 1;
        });

        static::saving( function($model)
        {
            if ( $model->model_id == null )
                $model->model_type = null;
            elseif ( $model->model_type == null )
                $model->model_id = null;

            if ( $model->model_id )
                $model->tab = null;

            if(empty($model->tab))
                $model->tab = self::DEFAULT_TAB;


            Cache::forget('view_props');
        });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION);
    }

    public static function typeKeys()
    {
        return array_keys( self::TYPES );
    }

    public static function allowedModelTypes()
    {
        return [...array_keys(Prop::ALLOWED_MODELS), ...Prop::ALLOWED_MODELS];
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


    public function getAdminValueAttribute()
    {
        if ( $this->attributes['type'] == 'file' )
            return $this->admin_file;
        elseif ( $this->attributes['type'] == 'files' )
            return $this->admin_files;
        elseif ( $this->attributes['type'] == 'text_array' )
            return $this->value_text;
        else
            return $this->value;
    }

    public function getAdminFileAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION);
    }
    public function getAdminFilesAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION);
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

    public function scopeGet4Admin($query, $addValues = true)
    {
        $list = $query
                ->ordered()
                ->get();

        if ($addValues)
            $list = $list->map->append('admin_value');

        return $list;
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


    public function scopeTabs($query)
    {
        $tabs = self::select('tab')
                ->whereNotNull('tab')
                ->whereNull('model_id')
                ->groupBy('tab')
                ->pluck('tab')
                ->prepend(self::DEFAULT_TAB)
                ->unique();
        return $tabs;
    }

    public function updateItem($data)
    {
        if (isset($data['key'])) {
            return $this->update($data);
        }

        $value = $data['admin_value'] ?? null;

        if ( in_array( $this->attributes['type'], ['string', 'boolean'] ) ) {
            $this->value_string = $value;
        }
        elseif (in_array($this->attributes['type'], ['file', 'files'])) {
            $this->syncMedia($value, self::MEDIA_COLLECTION);
        }
        else {
            $this->value_text = $value;
        }

        return $this->save();
    }


}
