<?php

namespace App\Models\Admin;

use App\Models\Prop as BaseModel;
use Illuminate\Support\Facades\Cache;

class Prop extends BaseModel
{

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

    public static function typeKeys()
    {
        return array_keys( self::TYPES );
    }

    public static function allowedModelTypes()
    {
        return [...array_keys(self::ALLOWED_MODELS), ...self::ALLOWED_MODELS];
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


    public function scopeGet4Admin($query, $addValues = true)
    {
        $list = $query
                ->ordered()
                ->get();

        if ($addValues)
            $list = $list->map->append('admin_value');

        return $list;
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
