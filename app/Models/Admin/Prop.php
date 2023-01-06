<?php

namespace App\Models\Admin;

use App\Models\Prop as BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Prop extends BaseModel
{

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
            $builder->orderBy('model_id');
            $builder->orderBy('position');
        });
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

    protected function value(): Attribute
    {
        return Attribute::make(
            get: function($value, $attributes) {
                $type = $attributes['type'];

                if ( $type == 'string' )
                    return ['string' => $this->value_string];
                elseif ( in_array($type, ['file', 'files']) )
                    return ['files' => $this->getAdminMedia(self::MEDIA_COLLECTION_FILE)];

                elseif ( in_array($type, ['image', 'images']) )
                    return ['images' => $this->getAdminMedia(self::MEDIA_COLLECTION_IMAGE)];

                elseif ( $type == 'text_array' )
                    return ['text_array' => $this->text_array];
                else
                    return ['text' => $this->value_text];
            },
        );
    }

    public function getTabAttribute($value)
    {
        if ($this->model)
            return $this->model->title;
        return $value;
    }

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::slug($value, '_');
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
        $value = $data['value'] ?? [];
        $type = $this->attributes['type'];

        if (in_array($type, ['file', 'files']))
            $this->syncMedia($value['files'] ?? null, self::MEDIA_COLLECTION_FILE);
        elseif (in_array($type, ['image', 'images']))
            $this->syncMedia($value['images'] ?? null, self::MEDIA_COLLECTION_IMAGE);

        elseif (in_array($type, ['string', 'boolean']))
            $this->attributes['value_string'] = $value['string'] ?? null;

        elseif ($type == 'text_array')
            $this->attributes['value_text'] = json_encode($value['text_array'] ?? null);
        else
            $this->attributes['value_text'] = $value['text'] ?? null;

        // faker...
        unset($data['value']);

        $this->fill($data);

        return $this->save();
    }


}
