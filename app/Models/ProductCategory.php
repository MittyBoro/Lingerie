<?php

namespace App\Models;

use App\Models\Translations\ProductCategoryTranslation;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

class ProductCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithCustomMedia;
    use NodeTrait;

    const MEDIA_COLLECTION = 'categories';

    public $timestamps = false;

    protected $hidden = ['_lft', '_rgt', 'pivot', 'ancestors'];

    protected $fillable = [
        'parent_id', // мб пофиксить
        'position',
        'slug',
        '_lft',
        '_rgt'
    ];

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('position');
        });
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(self::MEDIA_COLLECTION)
            ->singleFile()
            ->registerMediaConversions(function () {
                $this
                    ->addMediaConversion('thumb')
                    ->fit(Manipulations::FIT_CROP, 400, 400);
            });
    }

    public function mediaCollectionsWithDeletingOriginal(): array
    {
        return [
            self::MEDIA_COLLECTION,
        ];
    }

    public function translations()
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    protected function href(): Attribute
    {
        return Attribute::make(
                    get: fn () => route('front.categories', $this->slug)
                );
    }
    protected function preview(): Attribute
    {
        return Attribute::make(
                    get: fn () => $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'thumb')
                );
    }

    public function scopeGetAllCategories($query)
    {
        return $query
                ->withDepth()
                ->get()
                ->toFlatTree()
                // ->where('models_count', '>', 0)
                ->values();
    }

    public function scopeGetTree($query)
    {
        $data = $query
                    ->select('id', 'position', '_lft', '_rgt', 'parent_id')
                    ->withCount('products')
                    ->get()
                    ->toTree();
        return $data;
    }

    public function scopeLocalized($query, $lang = null, $fullData = false)
    {
        if (!$lang) {
            $lang = 'ru';
        }

        $query
            ->join('product_category_translations', 'product_categories.id', '=', 'product_category_translations.category_id')
            ->where('product_category_translations.lang', $lang)
            ->addSelect(
                'product_categories.id',
                'product_categories._lft',
                'product_categories._rgt',
                'product_categories.parent_id',
                'product_categories.slug',
                'product_category_translations.title',
            );

        if ($fullData) {
            $query
                ->addSelect(
                    'product_category_translations.description',
                    'product_category_translations.meta_title',
                    'product_category_translations.meta_description',
                    'product_category_translations.meta_keywords',
                );
        }
    }

    public function scopeGetFrontParentList($query, $lang)
    {
        $slugs = ['underwear', 'swimwear', 'homewear', 'linen_sets'];
        $result = $query
                    ->whereIn('slug', $slugs)
                    ->localized($lang)
                    ->with(['media'])
                    ->orderByRaw("FIELD(`slug`, '".implode("','", $slugs)."')")
                    ->get();

        $result->append('preview');

        return $result;
    }

    public function scopeGetFrontList($query, $lang)
    {
        $result = $query
                    ->localized($lang)
                    ->withDepth()
                    ->get();

        $result->append('href');

        return $result->toTree();
    }

    public function scopeFindForFront($query, $slug, $lang)
    {
        $result = $query
                    ->whereSlug($slug)
                    ->localized($lang, true)
                    ->firstOrFail();

        return $result;
    }




}
