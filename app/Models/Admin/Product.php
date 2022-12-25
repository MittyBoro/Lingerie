<?php

namespace App\Models\Admin;

use App\Models\Product as BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Product extends BaseModel
{

    public static function boot()
    {
        parent::boot();

        static::saving( function($query)
        {
            if ( empty($query->meta_title) )
                $query->meta_title = $query->title;
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

    public function setSlugAttribute($val)
    {
        $this->attributes['slug'] = Str::slug($val);
    }

    public function getGalleryAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION, 'thumb');
    }

    public function getSizeTableAttribute()
    {
        return $this->getAdminMedia(self::MEDIA_COLLECTION_SIZE_TABLE);
    }

    public function saveRelations($data)
    {
        // if ( isset($data['categories']) ) {
        //     $categories = ProductCategory::whereIn('id', $data['categories'])
        //                     ->with('ancestors')
        //                     ->get()
        //                     ->map(
        //                         fn ($item) => [ $item->id, $item->ancestors->pluck('id') ]
        //                     )
        //                     ->flatten()
        //                     ->unique();

        //     $this->categories()->sync($categories);
        // }

        // if ( isset($data['variations']) ) {
        //     $this->variations()->getRelated()->massSync($data['variations'], $this->id);
        // }

        if ( isset($data['gallery']) ) {
            $this->syncMedia($data['gallery'], self::MEDIA_COLLECTION);
        }
        if ( isset($data['size_table']) ) {
            $this->syncMedia($data['size_table'], self::MEDIA_COLLECTION_SIZE_TABLE);
        }
    }

}
