<?php

namespace App\Services\Cart\Traits;

use App\Models\Bonus;
use Cart;
use Darryldecode\Cart\CartCondition;


trait BonuseTrait
{

	public function getFutureBonuses()
	{
		if ( !$this->allowAddBonuses() )
			return 0;

		$sum = $this->list()->sum(function($item) {
			return $item->attributes->bonuses * $item->quantity;
		});

		return $sum;
	}

	public function getBonusLimit($balance)
	{
		$total = $this->getSubTotal();
		$allowByTotal = Bonus::getMaxPaymentByTotal($total);

		return min($allowByTotal, $balance);
	}

	public function applyCartBonuses($bonuses)
	{
		if (!$this->allowAddBonuses())
			return;

		$condition = new CartCondition([
			'name' => 'bonuses',
			'type' => 'bonuses',
			'target' => 'total',
			'value' => $bonuses * -1,
		]);

		Cart::condition($condition);
	}

	public function getCartBonuses()
	{
		return Cart::getCondition('bonuses')?->getValue() ?? 0;
	}

	public function clearCartBonuses()
	{
		Cart::removeCartCondition('bonuses');
	}

	public function allowAddBonuses()
	{
		return $this->promoCodeInstance->getModel()?->add_bonuses !== 0;
	}

}
