<?php

namespace App\Services\Cart\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;

trait DeliveryTrait
{

	public function getCartDelivery()
	{
		$condition = Cart::getCondition('delivery');

		if (!$condition)
			$condition = 0;
		else
			$condition = $condition->getValue();

		return $condition;
	}

	public function updateCartDelivery()
	{
		if ($this->allowFreeDelivery())
			$delivery = 0;
		else
			$delivery = config('alevi.delivery.cost');

		$condition = new CartCondition([
			'name' => 'delivery',
			'type' => 'delivery',
			'target' => 'total',
			'value' => $delivery,
		]);

		Cart::condition($condition);
	}

	private function allowFreeDelivery()
	{
		$total = Cart::getTotal();

		$allowByTotal = $total >= config('alevi.delivery.free_from');

		$allowByPromo = !$this->promoCodeInstance->getCode() || config('alevi.delivery.free_with_promo');

		return $allowByTotal && $allowByPromo;
	}

}
