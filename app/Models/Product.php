<?php

namespace App\Models;

use App\Models\Traits\ProductCartTrait;
use App\Models\Translations\ProductTranslation;
use App\Services\SpatieMedia\InteractsWithCustomMedia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements HasMedia
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

    protected $casts = [
        'is_published' => 'bool',
        'is_stock'     => 'bool',
    ];

    protected $searchable = [
        'columns' => [
            'product_translations.title' => 3,
            'product_translations.texts' => 1,
        ],
        'joins' => [
            'product_translations' => ['products.id','product_translations.product_id'],
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
            ->addMediaCollection(self::MEDIA_COLLECTION_SIZE_TABLE)
            ->singleFile();
    }

    public function registerMediaCollectionsWithDeletingOriginal(): array
    {
        return [
            self::MEDIA_COLLECTION,
            self::MEDIA_COLLECTION_SIZE_TABLE,
        ];
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class)->orderBy('position');
    }

    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class)->orderBy('position');
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

    public function scopeLocalizedData($query, $lang = null, $fullData = false)
    {
        if (!$lang) {
            $lang = 'ru';
        }

        $query
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.lang', $lang)
            ->addSelect(
                'products.id',
                'product_translations.title',
                'product_translations.slug',
                'product_translations.price',
            );

        if ($fullData) {
            $query
                ->addSelect(
                    'product_translations.texts',
                    'product_translations.meta_title',
                    'product_translations.meta_description',
                    'product_translations.meta_keywords',
                );
        }
    }
}
