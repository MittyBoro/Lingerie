<?php

namespace App\Models;

use App\Models\Traits\ProductCartTrait;
use App\Models\Traits\RetrievingTrait;
use App\Models\Translations\ProductTranslation;
use App\Services\SpatieMedia\InteractsWithCustomMedia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;
    // use SearchableTrait;
    // use ProductCartTrait;
    use RetrievingTrait;

    const MEDIA_COLLECTION            = 'images';
    const MEDIA_COLLECTION_SIZE_TABLE = 'size';

    protected $fillable = [
        'is_published',
        'is_stock',
        'position',
        'slug',
    ];

    protected $casts = [
        'is_published' => 'bool',
        'is_stock'     => 'bool',
        'texts'        => 'array',
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

    protected $sortable = ['position', 'created_at', 'price', 'title'];


    protected $hidden = ['media'];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION)
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 394, 525);
                $this
                    ->addMediaConversion('medium')
                    ->fit(Manipulations::FIT_MAX, 700, 700);
                $this
                    ->addMediaConversion('big')
                    ->fit(Manipulations::FIT_MAX, 1500, 1500);
            });

        $this
            ->addMediaCollection(self::MEDIA_COLLECTION_SIZE_TABLE)
            ->singleFile();
    }

    public function mediaCollectionsWithDeletingOriginal(): array
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
        return $this->belongsToMany(ProductCategory::class)->orderBy('position')->localized($this->lang);
    }

    public function options()
    {
        return $this->belongsToMany(ProductOption::class)->orderBy('position')
                        ->select('id', 'type', 'value', 'extra');
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

    public function scopeJoinTranslations($query, $lang = null)
    {
        if (!$lang) {
            $lang = 'ru';
        }
        $query
            ->join('product_translations', 'products.id', '=', 'product_translations.product_id')
            ->where('product_translations.lang', $lang);
    }

    public function scopeLocalized($query, $lang = null, $fullData = false)
    {

        $query
            ->joinTranslations($lang)
            ->addSelect(
                'products.id',
                'products.slug',
                'product_translations.title',
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


    public function scopeWhereCategory($query, $categoryId)
    {
        $query
            ->whereHas('categories', fn($q) => $q->where('id', $categoryId));
    }

    // catalog
    public function scopeGetFrontList($query, $lang)
    {
        $result = $query
                    ->isPublished()
                    ->localized($lang)
                    ->with('media')
                    ->customPaginate(6, ['gallery'])
                    ;

        return $result;
    }

    public function scopeMinMaxPrice($query, $lang)
    {
        $result = $query
                    ->isPublished()
                    ->joinTranslations($lang)
                    ->selectRaw('min(price) as min_price, max(price) as max_price')
                    ->first();

        return $result;
    }


    // single
    public function scopeFrontBySlug($query, $slug, $lang)
    {
        $result = $query
                    ->isPublished()
                    ->whereSlug($slug)
                    ->localized($lang, true)
                    ->with(['media', 'options'])
                    ->with('categories', fn ($q) =>
                            $q->with('ancestors', fn ($aQ) => $aQ->localized($lang))
                          )
                    ->firstOrFail();

        $result->append('gallery');

        return $result;
    }
}
