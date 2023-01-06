<?php

namespace App\Models\Admin;

use App\Models\Prop as BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Prop extends BaseModel
{

    const DEFAULT_TAB = 'Основное';

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

    protected $orderBy = ['position', 'asc'];
    protected $orderFileds = [
        'id',
        'tab',
        'key',
        'title',
        'type',
        'model_type',
    ];

    protected $appends = [
        'value',
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

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('position');
        });
    }

    public function getFileAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION_FILE);
    }
    public function getFilesAttribute()
    {
        return $this->file;
    }

    public function getImageAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION_IMAGE);
    }
    public function getImagesAttribute()
    {
        return $this->image;
    }

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::slug($value, '_');
    }
    
    protected function modelTypeKey(): Attribute
    {
        return Attribute::make(
            get: fn () => array_search($this->model_type, self::MODELS) ?: null,
            set: fn ($value) => [
                'model_type' => self::MODELS[$value] ?? null
            ],
        );
    }

    public function scopeGetList($query)
    {
        $list = $query
                ->ordered()
                ->get();

        return $list;
    }

    public static function tabs()
    {
        $tabs = self::select('tab')
                ->withoutGlobalScope('ordered')
                ->whereNotNull('tab')
                ->whereNull('model_id')
                ->groupBy('tab')
                ->pluck('tab')
                ->prepend(self::DEFAULT_TAB)
                ->unique();
        return $tabs;
    }

    public static function updateList($data)
    {
        $res = collect($data)->map(function ($item) {
            $prop = self::find($item['id']);
            $prop->updateItem($item);

            return $prop->id;
        });

        return $res;
    }

    public function updateItem($data)
    {
        $value = $data['value'] ?? null;

        if ( in_array( $this->attributes['type'], ['string', 'boolean'] ) ) {
            $this->value_string = $value;
        }
        elseif (in_array($this->attributes['type'], ['file', 'files'])) {
            $this->syncMedia($value, self::MEDIA_COLLECTION_FILE);
        }
        elseif (in_array($this->attributes['type'], ['image', 'images'])) {
            $this->syncMedia($value, self::MEDIA_COLLECTION_IMAGE);
        }
        else {
            $this->value_text = $value;
        }

        $this->fill($data);

        return $this->save();
    }


}
