<?php

namespace App\Models\Admin;

use App\Models\Product as Model;
use App\Models\Traits\Admin\TranslationTrait;
use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use TranslationTrait;
    use RetrievingTrait;


    protected $sortable = ['position', 'id', 'created_at', 'is_published', 'price', 'title'];


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

    public function scopelocalized($query, $lang = 'ru', $fullData = false)
    {
        $query->select('products.*');
        $query->addSelect('product_translations.lang');

        parent::scopelocalized($query, $lang, $fullData);
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
        if (array_key_exists('attributes', $data)) {
            $this->attributes()->sync($data['attributes']);
        }
        if (array_key_exists('categories', $data)) {
            $this->categories()->sync($data['categories']);
        }
        if (array_key_exists('translations', $data)) {
            $this->saveTranslations($data['translations']);
        }
        if (array_key_exists('gallery', $data)) {
            $this->syncMedia($data['gallery'], self::MEDIA_COLLECTION);
        }
        if (array_key_exists('size_table', $data)) {
            $this->syncMedia($data['size_table'], self::MEDIA_COLLECTION_SIZE_TABLE);
        }
    }

}
