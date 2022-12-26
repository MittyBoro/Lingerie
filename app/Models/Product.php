<?php

namespace App\Models;

use App\Models\Traits\ProductCartTrait;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;
    use SearchableTrait;
    use ProductCartTrait;

    const MEDIA_COLLECTION            = 'images';
    const MEDIA_COLLECTION_SIZE_TABLE = 'size';

    protected $fillable = [
        'is_published',
        'is_stock',
        'position',
    ];

    protected $orderBy = ['position', 'asc'];

    protected $orderFileds = [
        'id', 'created_at', 'is_published'
    ];

    protected $casts = [
        'attributes'   => 'array',
        'is_published' => 'bool',
        'is_stock'     => 'bool',
    ];

    protected $searchable = [
        'columns' => [
            'title' => 3,
            'description' => 2,
            'attributes' => 1,
        ],
    ];

    protected $appends = [
        'preview',
    ];

    protected $hidden = ['media'];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION)
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 400, 400);
                $this
                    ->addMediaConversion('medium')
                    ->fit(Manipulations::FIT_CROP, 640, 640);
                $this
                    ->addMediaConversion('big')
                    ->fit(Manipulations::FIT_MAX, 1280, 1280);
            });
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION_SIZE_TABLE);
    }

    public function registerMediaCollectionsWithDeletingOriginal(): array
    {
        return [
            self::MEDIA_COLLECTION,
        ];
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_model', 'model_id')->orderBy('position');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class)->with('promo_code_prices');
    }

    public function getGalleryAttribute()
    {
        $gallery = $this->getMediaUrlsConversions(self::MEDIA_COLLECTION, ['thumb', 'medium', 'big']);

        if ($gallery->count()) {
            return $gallery;
        }

        return collect([[
            'thumb' => $this->preview,
            'medium' => $this->preview,
            'big' => $this->preview,
        ]]);
    }

    public function getPreviewAttribute($val)
    {
        if ($val !== null)
            $preivew = $val;
        else
            $preivew = $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'medium');

        return $preivew;
    }

    public function getJsonAttribute()
    {
        return $this->only(['id', 'price', 'is_stock', 'slug', 'variations']);
    }

    public function getCurrentPriceAttribute()
    {
        return (int)$this->variations->min('price');
    }


    public function scopeIsPublished($query)
    {
        $query->where('is_published', 1);
    }


    public function scopeIsStock($query)
    {
        $query->where('is_stock', 1);
    }
    public function scopeOrderStock($query)
    {
        $query->orderByDesc('is_stock');
    }


    public function scopePublicCatalog($query, $category = null)
    {
        $query->isPublished()
                ->orderStock()
                ->when($category,
                    fn($q) => $q->whereHas('categories',
                        fn($b) => $b->where('id', $category->id)
                    )
                )
                ->select('id', 'title', 'slug', 'is_stock');
    }

    public function scopePriorityIds($query, $ids = null)
    {
        $query->when($ids, function ($q) use ($ids) {
            $placeholders = implode(', ', array_fill(0, count($ids), '?'));
            $q->orderByRaw("FIELD(id, {$placeholders}) DESC", $ids->sortDesc());
        });
    }

    public function scopeWithPrice($query, $select = null)
    {
        if ($select)
            $query->select($select);

        $query
            ->addSelect('variations_count', 'min_price', 'variation_groups')
            ->leftJoin(
                DB::Raw('
                        ( SELECT `product_id`,
                                COUNT(*) AS `variations_count`,
                                COUNT( DISTINCT `name` ) AS `variation_groups`,
                                MIN(NULLIF(`price`, 0)) AS `min_price`
                        FROM `product_variations`
                        GROUP BY `product_id` ) as `prod_v`'
                    ), 'id' , '=', 'prod_v.product_id');
    }
}
