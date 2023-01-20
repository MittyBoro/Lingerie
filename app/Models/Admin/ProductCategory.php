<?php

namespace App\Models\Admin;

use App\Models\ProductCategory as Model;
use App\Models\Traits\Admin\TranslationTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ProductCategory extends Model
{
    use TranslationTrait;

    protected $appends = ['title'];

    public static function boot()
    {
        parent::boot();

        static::creating( function($model)
        {
            $model->position = self::max('position') + 1;
        });

        static::updated( function()
        {
            static::fixTree();
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('translations', function (Builder $builder) {
            $builder->with('translations');
        });
    }

    public function getTitleAttribute()
    {
        return $this->translations->first()?->title;
    }

    public function scopeGetList($query)
    {
        $list = $query
                    ->withDepth()
                    ->get()
                    ->toFlatTree();

        return $list;
    }


    public function updateTree($items)
    {
        try {
            collect($items)->each(function($item, $key) {
                $item = Arr::only($item, ['id', 'parent_id']);
                $item['position'] = $key;

                static::where('id', $item['id'])->update($item);
            });

            static::fixTree();

        } catch (\Throwable $e) {
            return false;
        }

        return true;
    }

    public function saveAfter($data)
    {
        if ( isset($data['translations']) ) {
           $this->saveTranslations($data['translations']);
        }
    }

}
