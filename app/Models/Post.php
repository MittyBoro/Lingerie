<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Services\SpatieMedia\InteractsWithCustomMedia;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;

use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends BaseModel implements HasMedia
{
	use HasFactory;
	use InteractsWithCustomMedia;
	use SearchableTrait;

	protected $guarded = ['preview', 'photos', 'videos'];

	const MEDIA_COLLECTION_PREVIEW = 'preview';
	const MEDIA_COLLECTION_PHOTOS  = 'photos';
	const MEDIA_COLLECTION_VIDEOS  = 'videos';

	const CLEAR_ORIGINAL_IN_MEDIA_COLLECTION = [
		self::MEDIA_COLLECTION_PREVIEW,
		self::MEDIA_COLLECTION_PHOTOS,
	];

	const DEFAULT_PREVIEW  = 'images/default-preview.jpg';

	protected $casts = [
		'is_published' => 'bool',
		'published_at' => 'date',
	];

	protected $orderFileds = [
		'id', 'title', 'published_at', 'created_at', 'is_published'
	];

	protected $defaultOrder = ['published_at', 'desc'];

	protected $searchable = [
		'columns' => [
			'title' => 1,
			'description' => 1,
		],
	];

	protected $appends = [
		'preview',
	];


	public static function boot()
	{
		parent::boot();

		static::saving( function($query)
		{
			if ( !$query->meta_title )
				$query->meta_title = $query->title;
		});
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function partner()
	{
		return $this->belongsTo(Partner::class);
	}

	public function registerMediaCollections(): void
	{
		$this
			->addMediaCollection(self::MEDIA_COLLECTION_PREVIEW)
			->singleFile()
			->registerMediaConversions(function () {
				$this
					->addMediaConversion('thumb')
					->fit(Manipulations::FIT_CROP, 400, 400);
				$this
					->addMediaConversion('medium')
					->fit(Manipulations::FIT_MAX, 700, 700);
			});
		$this
			->addMediaCollection(self::MEDIA_COLLECTION_PHOTOS)
			->registerMediaConversions(function () {
				$this
					->addMediaConversion('thumb')
					->fit(Manipulations::FIT_CROP, 400, 400);
				$this
					->addMediaConversion('big')
					->fit(Manipulations::FIT_MAX, 1200, 1200);
			});
		$this
			->addMediaCollection(self::MEDIA_COLLECTION_VIDEOS);
	}

	public function registerMediaCollectionsWithDeletingOriginal(): array
	{
		return [
			self::MEDIA_COLLECTION_PREVIEW,
			self::MEDIA_COLLECTION_PHOTOS,
		];
	}


	public function getPreviewAttribute($val)
	{
		if ($this->editing)
			return $this->getAdminMedia(self::MEDIA_COLLECTION_PREVIEW, 'thumb');

		if ($val !== null)
			$preivew = $val;
		else
			$preivew = $this->getFirstMediaUrl(self::MEDIA_COLLECTION_PREVIEW, 'thumb');

		if (!$preivew)
			$preivew = asset(self::DEFAULT_PREVIEW);

		return $preivew;
	}

	public function getPhotosAttribute()
	{
		if ($this->editing)
			return $this->getAdminMedia(self::MEDIA_COLLECTION_PHOTOS, 'thumb');
		else
			return $this->getMediaUrlsConversions(self::MEDIA_COLLECTION_PHOTOS, ['thumb', 'big']);
	}
	public function getVideosAttribute()
	{
		if ($this->editing)
			return $this->getAdminMedia(self::MEDIA_COLLECTION_VIDEOS);
		else
			return $this->getMediaUrls(self::MEDIA_COLLECTION_VIDEOS);
	}

	public function getPublishedFormatedAttribute()
	{
		return $this->published_at?->formatLocalized('%d %B %Y');
	}

	public function saveRelations($data)
	{
		if ( isset($data['preview']) ) {
			$this->syncMedia($data['preview'], self::MEDIA_COLLECTION_PREVIEW);
		}
		if ( isset($data['photos']) ) {
			$this->syncMedia($data['photos'], self::MEDIA_COLLECTION_PHOTOS);
		}
		if ( isset($data['videos']) ) {
			$this->syncMedia($data['videos'], self::MEDIA_COLLECTION_VIDEOS);
		}
	}

	public function scopeIsPublished($query)
	{
		$query->where('is_published', 1);
	}

	public function scopePublicPosts($query)
	{
		$query->isPublished()
				->select('id', 'title', 'slug', 'published_at');
	}

}
