<?php

namespace App\Models;

use App\Models\Product\ProductOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonus extends BaseModel
{
    use HasFactory;
	use SoftDeletes;

	protected $defaultOrder = ['created_at', 'desc'];

	protected $casts = [
		'end_at' => 'datetime',
	];
	protected $orderFileds = [
		'id', 'title', 'amount', 'created_at', 'end_at'
	];


	public static function boot()
	{
		parent::boot();
		static::saved( function($query)
		{
			$query->user->recalculateBonuses();
		});
		static::deleted( function($query)
		{
			$query->user->recalculateBonuses();
		});
		static::forceDeleted( function($query)
		{
			$query->user->recalculateBonuses();
		});
		static::restored( function($query)
		{
			$query->user->recalculateBonuses();
		});
	}


	public function order()
	{
		return $this->belongsTo(ProductOrder::class, 'order_id');
	}
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public static function debitByOrder($order)
	{
		if (!$order->spent_bonuses)
			return;

		$data = [
			'user_id' => $order->user_id,
			'order_id' => $order->id,
			'title' => 'Списание за заказ #' . $order->id,
			'amount' => $order->spent_bonuses * -1,
		];

		self::create($data);
	}
	public static function appendByOrder($order)
	{
		$bonuses = $order->items->sum(function($item) {
			return $item->bonuses * $item->quantity;
		});

		// баллы плюсануть, прописать ордер и.. ну да, всё есть

		if (!$bonuses)
			return;

		$data = [
			'user_id' => $order->user_id,
			'order_id' => $order->id,
			'title' => 'Покупка #' . $order->id,
			'amount' => $bonuses,
		];

		$daysToDelete = self::getBuyDaysToDelete();
		if ($daysToDelete)
			$data['end_at'] = now()->addDays($daysToDelete);

		self::create($data);
	}

	public static function appendByRegister($user_id)
	{
		$amount = self::getSignupAmount();
		if (!$amount)
			return;

		$data = [
			'user_id' => $user_id,
			'title' => 'Регистрация',
			'amount' => $amount,
		];

		$daysToDelete = self::getSignupDaysToDelete();
		if ($daysToDelete)
			$data['end_at'] = now()->addDays($daysToDelete);

		self::create($data);
	}

	// на сколько пополнять за регистрацию
	public static function getSignupAmount()
	{
		return max( (int)Prop::byKey('bonuses_signup__amount'), 0 );
	}
	// черрез сколько удалять
	public static function getSignupDaysToDelete()
	{
		return max( (int)Prop::byKey('bonuses_signup__int_to_delete'), 0 );
	}

	// через сколько часов после покупки начислять
	public static function getBuyHoursToCharge()
	{
		return max( (int)Prop::byKey('bonuses_buy__int_to_charge'), 0 );
	}
	// сколько дней хранить при покупке / 0 бесспрочно
	public static function getBuyDaysToDelete()
	{
		return max( (int)Prop::byKey('bonuses_buy__int_to_delete'), 0 );
	}
	// сколько процентов можно оплатить
	public static function getBuyMaxPercentage()
	{
		return max( (int)Prop::byKey('bonuses_buy__max_percentage'), 0 );
	}


	// сколько максимум можно оплатить
	public static function getMaxPaymentByTotal($total)
	{
		return (int)(self::getBuyMaxPercentage() / 100 * $total);
	}


	public function scopeFilter($query, array $filter)
	{
		if (isset($filter['user_id'])) {
			$query->where( 'user_id' , $filter['user_id'] );
		}
	}
}
