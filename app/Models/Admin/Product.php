<?php

namespace App\Models\Admin;

use App\Models\Product as BaseModel;
use App\Models\Admin\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Builder;

class Product extends BaseModel
{
    use TranslationTrait;

    protected static function booted()
    {
        static::addGlobalScope('translations', function (Builder $builder) {
            $builder->with('translations');
        });
    }

    public function scopeFilter($query, array $filter)
    {
        if (isset($filter['category'])) {
            $query->whereHas('categories', function(Builder $query) use ($filter) {
                $query->where( 'id' , $filter['category'] );
            });
        }

        if (isset($filter['q'])) {
            $query->search($filter['q']);
        }
    }

    public function getTitleAttribute()
    {
        return $this->translations->first()?->title;
    }

    public function getGalleryAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION, 'thumb');
    }

    public function getSizeTableAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION_SIZE_TABLE);
    }

    public function saveAfter($data)
    {
        if ( isset($data['attributes']) ) {
            $this->attributes()->sync($data['attributes']);
        }
        if ( isset($data['categories']) ) {
            $this->categories()->sync($data['categories']);
        }

        if ( isset($data['translations']) ) {
           $this->saveTranslations($data['translations']);
        }

        if ( isset($data['gallery']) ) {
            $this->syncMedia($data['gallery'], self::MEDIA_COLLECTION);
        }
        if ( isset($data['size_table']) ) {
            $this->syncMedia($data['size_table'], self::MEDIA_COLLECTION_SIZE_TABLE);
        }
    }

}
