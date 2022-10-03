<?php

namespace App\Services\Cart\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;

use App\Models\Product\ProductVariation;

trait PromoCodeTrait
{

	public function applyPromoCode($promo_code = null)
	{
		if ($promo_code)
			$this->promoCodeInstance->set($promo_code);

		$this->getContent()->each(function($item) {
			$this->applyPromoCode4Item($item);
		});

		$this->updateCartDelivery();

		return true;
	}

	public function applyPromoCode4Item($item)
	{
		$codeModel = $this->promoCodeInstance->getModel();

		if (!$codeModel)
			return Cart::clearItemConditions($item->id);

		$ids = collect($item->attributes->variations)->pluck('id');

		$variations = ProductVariation::with('promo_code_prices')->whereIn('id', $ids)->get();

		$price = $variations->sum('price');

		$promoPrices = $variations->map(function($varItem) use ($codeModel) {
			if ($varItem->price == 0)
				return collect([0]);

			return $varItem->promo_code_prices
						->where('promo_code_id', $codeModel->id)
						->where('price', '!=', '0')
						->pluck('price');
		})->collapse();

		if ( $promoPrices->count() )
		{
			$difference = $price - $promoPrices->sum();

			$updateCart = [
				'conditions' => new CartCondition([
						'name' => $codeModel->code,
						'type' => 'coupon',
						'value' => '-'. $difference,
					])
			];
			Cart::update($item->id, $updateCart);
		} else
			Cart::clearItemConditions($item->id);


	}

	public function clearPromoCode()
	{
		$this->getContent()->each(function($item) {
			Cart::clearItemConditions($item->id);
		});

		$this->promoCodeInstance->clear();
	}

	public function getPromoCode()
	{
		return $this->promoCodeInstance->getCode();
	}

}
