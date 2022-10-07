<?php

namespace App\Models;

use App\Events\ProductOrderPaid;

use Illuminate\Support\Facades\DB;

class Order extends BaseModel
{
	protected $casts = [
		'address' => 'array',
	];

	const STATUS_PENDING  = 'pending';
	const STATUS_SUCCESS  = 'success';
	const STATUS_CANCELED = 'canceled';
	const STATUS_REFUNDED = 'refunded';

	public static function boot()
	{
		parent::boot();

		static::created( function($model)
		{
		});

		static::saving( function($model)
		{
			if ($model->status != $model->getOriginal('status')) {
				if ($model->status == self::STATUS_SUCCESS) {
					event(new ProductOrderPaid($model));
				}

				// if ($model->status != self::STATUS_PENDING)
				// 	$model->url = null;

			}
		});

		static::deleted( function($model)
		{
			$model->cancelDebitBonuses();
		});
	}

	public static function statuses()
	{
		return [
			self::STATUS_PENDING,
			self::STATUS_SUCCESS,
			self::STATUS_CANCELED,
			self::STATUS_REFUNDED,
		];
	}

	public function items()
	{
		return $this->hasMany(ProductOrderItem::class, 'order_id')->with('product');
	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function cancelDebitBonuses()
	{
		return $this->debit_bonus?->forceDelete();
	}

	public function getOldAmountAttribute()
	{
		return $this->items->sum('sum_old_price');
	}

	public function getDiscountsAttribute()
	{
		return ($this->old_amount + $this->delivery - $this->amount) * -1;
	}

	public function getIsPaidAttribute()
	{
		return $this->status == self::STATUS_SUCCESS;
	}

	public static function createOrder($data, $items)
	{
		$order = DB::transaction(function () use ($data, $items) {
			$order = self::create($data);
			$order->items()->createMany($items);

			return $order;
		});

		return $order;
	}

	public function scopeIsPaid($query)
	{
		$query->where('status', self::STATUS_SUCCESS);
	}

	public function scopeSumAndCount($query)
	{
		$query
			->isPaid()
			->selectRaw('SUM(`amount`) as `sum`, COUNT(*) AS `count`');
	}

	public function scopeUser($query, $user_id)
	{
		$query->where('user_id', $user_id);
	}
	public function setSuccess()
	{
		$this->update([
			'status' => self::STATUS_SUCCESS,
		]);
	}
	public function setCanceled()
	{
		$this->update([
			'status' => self::STATUS_CANCELED,
		]);
	}
	public function setPending()
	{
		$this->update([
			'status' => self::STATUS_PENDING
		]);
	}
	public function setRefunded()
	{
		$this->update([
			'status' => self::STATUS_REFUNDED
		]);
	}

	public function scopeFilter($query, array $filter)
	{
		if (isset($filter['user_id'])) {
			$query->where( 'user_id' , $filter['user_id'] );
		}
	}


}
