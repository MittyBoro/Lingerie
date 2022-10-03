<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends BaseModel
{
	use HasFactory;

	public $timestamps = false;

	protected $defaultOrder = ['id', 'asc'];

	protected $orderFileds = [
		'id', 'code', 'is_active'
	];

	protected $casts = [
		'is_active' => 'bool',
	];

	protected $hidden = ['percent'];

	public function scopeCreateItem()
	{
		$code = 'ПРОМО'. ($this->count() + 1);
		$data = [
			'code' => $code,
		];

		return $this->create($data);
	}

	public function scopeIsActive($query)
	{
		$query->where('is_active', 1);
	}

	public static function getByCode($code)
	{
		return self::isActive()->where('code', $code)->first();
	}

}
