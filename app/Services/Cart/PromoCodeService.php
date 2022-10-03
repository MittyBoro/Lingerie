<?php

namespace App\Services\Cart;

use App\Models\Product\PromoCode;
use Cart;
use Darryldecode\Cart\CartCondition;

class PromoCodeService
{
	private $promoCode;
	private $promoCodeModel;

	private $codeKey = 'promo_code';

	public function __construct()
	{
		$this->set($this->getFromCondition(), false);
	}

	public function set($code, $setNew = true)
	{
		if ($code) {
			$model = PromoCode::getByCode($code);

			if ($model) {
				$this->promoCode = $model->code;
				$this->promoCodeModel = $model;

				if ($setNew)
					$this->setToCondition();

				return;
			}
			else {
				return $this->clear();
			}
		}

		$this->clear(false);
	}

	private function setToCondition()
	{
		$condition = new CartCondition([
			'name' => $this->codeKey,
			'type' => $this->codeKey,
			'value' => 0,
			'attributes' => [
				'code' => $this->promoCode,
			],
		]);
		Cart::condition($condition);
	}
	private function getFromCondition()
	{
		$condition = Cart::getCondition($this->codeKey);
		return $condition?->getAttributes()['code'] ?? null;
	}

	public function getCode()
	{
		return $this->promoCode;
	}
	public function getModel()
	{
		return $this->promoCodeModel;
	}

	public function clear($clearCondition = true)
	{
		if ($clearCondition)
			Cart::removeCartCondition($this->codeKey);

		$this->promoCode = null;
		$this->promoCodeModel = null;
	}


}
