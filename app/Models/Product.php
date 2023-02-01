<?php

namespace App\Models;

use App\Models\Traits\ProductCartTrait;
use App\Models\Traits\RetrievingTrait;
use App\Models\Translations\ProductTranslation;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;
    use ProductCartTrait;
    use RetrievingTrait;
    // use SearchableTrait;

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
        'details'        => 'array',
    ];

    protected $searchable = [
        'columns' => [
            'product_translations.details' => 3,
            'product_translations.details' => 1,
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
        ];
    }

    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class)
                    ->orderBy('position')
                    ->withDepth();
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
            'thumb' => '',
            'medium' => '',
            'big' => '',
        ]]);
    }

    public function getSizesTableAttribute()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_SIZE_TABLE);
    }

    public function getOptsAttribute()
    {
        return $this->options->groupBy('type');
    }
    public function getSizesAttribute()
    {
        return $this->options->where('type', 'size');
    }

    public function getDetailsAttribute($value)
    {
        $details = json_decode($value, true);
        $keys = ['description', 'composition', 'care'];
        $details = array_merge(array_combine($keys, $keys), $details);

        return $details;
    }

    public function getBreadCatsAttribute()
    {
        $categories = $this->categories->sortByDesc('depth');
        if ($categories->isEmpty()) {
            return collect();
        }

        $category = $categories->first();
        $category->makeHidden('ancestors');
        $ancestors = $category->ancestors ?? collect();

        return collect($ancestors)->concat([$category]);
    }

    // запрос не дублируется
    protected function preview(): Attribute
    {
        return Attribute::make(
                    get: fn () => $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'medium')
                );
    }

    // запрос не дублируется
    protected function similars(): Attribute
    {
        return Attribute::make(get: function () {
            $categories = $this->categories->pluck('id');

            $result = self::limit(4)
                        ->where('products.id', '!=', $this->id)
                        ->relationByIds('categories', $categories)
                        ->getFrontList($this->lang, false);

            $result->append(['gallery']);
            return $result;
        });
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
                'product_translations.lang',
            );

        if ($fullData) {
            $query
                ->addSelect(
                    'product_translations.details',
                    'product_translations.meta_title',
                    'product_translations.meta_description',
                    'product_translations.meta_keywords',
                );
        }
    }


    public function scopeRelationByIds($query, $relation, $ids = null)
    {
        if ($ids) {
            if (is_string($ids)) {
                $ids = explode(',', $ids);
            }
            $query->whereRelation(
                $relation,
                fn($q) => $q->whereIn('id', collect($ids))
            );
        }
    }

    // catalog
    public function scopeGetCatalog($query, $lang, $data)
    {
        return $query
                ->orderByStr($data['sort'] ?? null)
                ->priceBetween($data['price'] ?? null)
                ->relationByIds('options', $data['options'] ?? null)
                ->relationByIds('categories', $data['categories'] ?? null)
                ->getFrontList($lang);
    }
    public function scopeGetFrontList($query, $lang, $paginate = true, $append = 'gallery')
    {
        $query
            ->isPublished()
            ->localized($lang)
            ->with('media');

        if ($paginate) {
            $result = $query->customPaginate(6, $append);
        }
        else {
            $result = $query->get();
            $result->append($append);
        }

        return $result;
    }
    public function scopeMinMaxPrice($query, $lang)
    {
        $result = $query
                    ->isPublished()
                    ->joinTranslations($lang)
                    ->selectRaw('min(price) as `0`, max(price) as `1`')
                    ->first()
                    ->toArray();

        return $result;
    }
    public function scopePriceBetween($query, $price = null)
    {
        if (is_string($price)) {
            $price = explode(',', $price);
        }
        if (is_array($price) && count($price) == 2) {
            $query->whereBetween('price', [...$price]);
        }
    }
    public function scopePricesById($query, $ids, $lang,)
    {
        return $query
                ->localized($lang)
                ->whereIn('products.id', $ids)
                ->get();
    }



    // single
    public function scopeFrontBySlug($query, $slug, $lang)
    {
        $result = $query
                    ->isPublished()
                    ->whereSlug($slug)
                    ->localized($lang, true)
                    ->with(['media', 'options'])
                    ->with('categories',
                        fn ($q) =>
                            $q->localized($lang)
                              ->with('ancestors', fn ($aQ) => $aQ->localized($lang))

                        )
                    ->firstOrFail();

        $result->append(['gallery', 'opts', 'sizes_table', 'bread_cats', 'similars']);
        $result->makeHidden(['options']);

        return $result;
    }
}
