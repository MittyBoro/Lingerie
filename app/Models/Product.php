<?php

namespace App\Models;

use App\Models\Traits\ProductCartTrait;
use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;

use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends BaseModel implements HasMedia
{
	use HasFactory;
	use InteractsWithCustomMedia;
	use SearchableTrait;
	use ProductCartTrait;

	const MEDIA_COLLECTION = 'gallery';
	const DEFAULT_PREVIEW  = 'images/default-preview.jpg';

	protected $guarded = [
		'categories',
		'gallery',
		'variations',
	];

	protected $defaultOrder = ['position', 'asc'];

	protected $orderFileds = [
		'id', 'title', 'min_price', 'variations_count', 'variation_groups', 'created_at', 'position', 'is_stock', 'is_published', 'category_id'
	];

	protected $casts = [
		'characteristics' => 'array',
		'is_published' => 'bool',
		'is_stock' => 'bool',
	];

	protected $searchable = [
		'columns' => [
			'title' => 3,
			'description' => 2,
			'characteristics' => 1,
		],
	];

	protected $appends = [
		'preview',
	];

	protected $hidden = ['media'];

	public static function boot()
	{
		parent::boot();

		static::saving( function($query)
		{
			if ( empty($query->meta_title) )
				$query->meta_title = $query->title;
		});
	}

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
	}

	public function registerMediaCollectionsWithDeletingOriginal(): array
	{
		return [
			self::MEDIA_COLLECTION,
		];
	}


	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class, 'category_model', 'model_id')->orderBy('position');
	}

	public function variations()
	{
		return $this->hasMany(ProductVariation::class)->with('promo_code_prices');
	}

	public function saveRelations($data)
	{
		if ( isset($data['categories']) ) {
			$categories = ProductCategory::whereIn('id', $data['categories'])
							->with('ancestors')
							->get()
							->map(
								fn ($item) => [ $item->id, $item->ancestors->pluck('id') ]
							)
							->flatten()
							->unique();

			$this->categories()->sync($categories);
		}

		if ( isset($data['variations']) ) {
			$this->variations()->getRelated()->massSync($data['variations'], $this->id);
		}

		if ( isset($data['gallery']) ) {
			$this->syncMedia($data['gallery'], self::MEDIA_COLLECTION);
		}
	}

	public static function characteristicsList()
	{
		return self::pluck('characteristics')->flatten(1)->pluck('name')->unique();
	}


	public function getGalleryAttribute()
	{
		if ($this->editing)
			return $this->getAdminMedia(self::MEDIA_COLLECTION, 'thumb');
		else {
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
	}


	public function getPreviewAttribute($val)
	{
		if ($val !== null)
			$preivew = $val;
		else
			$preivew = $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'medium');

		if (!$preivew)
			$preivew = asset(self::DEFAULT_PREVIEW);

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

	public function setSlugAttribute($val)
	{
		$this->attributes['slug'] = Str::slug($val);
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
