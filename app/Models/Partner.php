<?php

namespace App\Models;

use App\Services\Cities;
use App\Services\SpatieMedia\InteractsWithCustomMedia;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Partner extends BaseModel implements HasMedia
{
	use HasFactory;
    use InteractsWithCustomMedia;

	protected $perPage = 30;

	const MEDIA_COLLECTION = 'partners';

	const INFO_TYPES = [
		'text' => 'Текст',
		'url' => 'Ссылка',
		'vk' => 'VK',
		'instagram' => 'Instagram',
		'phone' => 'Телефон',
	];

	protected $orderFileds = [
		'id', 'city', 'created_at'
	];

	protected $casts = [
		'information'    => 'array',
		'is_franchisee'  => 'bool',
		'is_distributor' => 'bool',
		'is_published'   => 'bool',
	];

	protected $appends = [
		// 'avatar',
	];

	protected $defaultOrder = ['city', 'desc'];


	public static function boot()
	{
		parent::boot();

		static::saving( function($query)
		{
			if ($query->information === null)
				$query->information = [];

			Cities::forgetCache();
		});
	}

	public function registerMediaCollections(): void
	{
		$this
			->addMediaCollection(self::MEDIA_COLLECTION)
			->singleFile()
			->registerMediaConversions(function (Media $media) {
				$this
					->addMediaConversion('thumb')
					->fit(Manipulations::FIT_CROP, 100, 100);
			});
	}

	public function getAvatarAttribute()
	{
		return $this->getFirstMediaUrl(self::MEDIA_COLLECTION, 'thumb');
	}

	public function getSlugCityAttribute()
	{
		if (!$this->city)
			return null;

		$city = Cities::list()->firstWhere('original_name', $this->city);
		return $city ? $city['slug'] : null;
	}

	public function getFirstLettersAttribute()
	{
		$pos = mb_strpos($this->person_name, " ");
		return mb_substr($this->person_name, 0, 1) . mb_substr($this->person_name, $pos + 1, 1);
	}

	public function getSortedInformationAttribute()
	{
		$information = $this->information;
		$order = array_keys(Partner::INFO_TYPES);
		uksort($information, function($key1, $key2) use ($order, $information) {
			$type1 = $information[$key1]['type'];
			$type2 = $information[$key2]['type'];
			return ((array_search($type1, $order) > array_search($type2, $order)) ? 1 : -1);
		});

		return $information;
	}



	public function scopeCreateItem($query)
	{
		$data = [
			'person_name' => 'Имя Фамилия #'. ($this->count() + 1),
		];

		return $this->create($data);
	}

	public function scopeUpdateItem($query, $data)
	{
		$updated = $this->update($data);

		return $updated;
	}

	public function scopeCities($query, $byCount = false)
	{

		$query->select('city')
					->whereNotNull('city')
					->groupBy('city');

		if ($byCount) {
			$query
				->selectRaw('COUNT(*) as count')
				->orderByDesc('count');
		} else {
			$query->orderBy('city');
		}
		return $query->pluck('city');
	}

	public function scopeFilter($query, $filter)
	{
		if (isset($filter['who'])) {
			if ($filter['who'] == 'is_franchisee') {
				$query->where('is_franchisee', true);
			}
			if ($filter['who'] == 'is_distributor') {
				$query->where('is_distributor', true);
			}
		}

		if (isset($filter['person_name'])) {
			$query->where('person_name', 'like', '%'.$filter['person_name'].'%');
		}

		if (isset($filter['city'])) {
			$query->where('city', 'like', '%'.$filter['city'].'%');
		}
	}

	public function scopeIsPublished($query)
	{
		$query->where('is_published', 1);
	}

	public function scopeFranchisee($query)
	{
		$query->isPublished();
		$query->where('is_franchisee', true);
		$query->orderBy('city');
	}

	public function scopeDistributors($query)
	{
		$query->isPublished();
		$query->where('is_distributor', true);
		$query->orderBy('city');
	}

	public function scopePublicSelect($query)
	{
		$query->select('id', 'is_franchisee', 'is_distributor', 'is_published', 'person_name', 'city', 'company_name', 'address', 'description', 'information');
	}

	public static function franchiseeAdresses()
	{
		$addrs = self::franchisee()
					 ->get(['address', 'city', 'id'])
					 ->map(function($item) {
						 return [
							 'id' => $item->id,
							 'address' => trim(($item->city . ', ' . $item->address), ', ')
						 ];
					 });

		return $addrs;

	}

}
