<?php

namespace App\Models\Admin;

use App\Models\ProductCategory as BaseModel;
use App\Models\Admin\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class ProductCategory extends BaseModel
{

    use TranslationTrait;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('translations', function (Builder $builder) {
            $builder->with('translations');
        });

        static::creating( function($model)
        {
            $model->position = self::max('position') + 1;
        });

        static::updated( function($model)
        {
            static::fixTree();
        });
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

    public function saveRelations($data)
    {
        if ( isset($data['translations']) ) {
           $this->saveTranslations($data['translations']);
        }
    }

}
