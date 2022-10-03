<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CartController extends Controller
{

	public function get(Request $request): array
	{
		$request->cart->recalculateCart();

		return [
			...$this->getCartData($request),
		];
	}

	private function getCartData(Request $request): array
	{
		$cart = $request->cart->list();
		$promocode = $request->cart->getPromoCode();
		$futureBonuses = $request->cart->getFutureBonuses();

		return [
			'cart' => $cart,
			'promocode' => $promocode,
			'future_bonuses' => $futureBonuses,
		];
	}

	public function add(Request $request)
	{
		$data = $request->validate([
			'count'           => 'required|min:1',
			'product_id'      => 'required|exists:products,id',
			'variation_ids'   => 'required|array|min:1',
			'variation_ids.*' => [
				'required',
				Rule::exists('product_variations', 'id')->where(function ($query) use ($request) {
					return $query->where('product_id', $request->product_id);
				})
			],
		]);

		$add = $request->cart->add($data);

		if ( !$add )
			return [
				'success' => false,
				'message' => 'Ошибка товара',
			];

		return [
			'success' => true,
			'count' => $add,
		];
	}

	public function update(Request $request)
	{
		$validated = $request->validate([
			'id' => 'string',
			'quantity' => 'integer|min:1',
		]);

		$request->cart->updateQuantity($validated['id'], $validated['quantity']);

		return [
			'success' => true,
			...$this->getCartData($request)
		];
	}

	public function remove(Request $request)
	{
		$request->cart->remove($request->get('id'));

		return [
			'success' => true,
			...$this->getCartData($request)
		];
	}

	public function applyPromoCode(Request $request)
	{
		$apply = $request->cart->applyPromoCode($request->get('code'));

		if (!$apply)
		{
			return [
				'success' => false,
				'message' => 'Промокод не найден',
			];
		}

		return [
			'success' => true,
			...$this->getCartData($request)
		];
	}

	public function applyBonuses(Request $request)
	{
		$apply = $request->cart->applyPromoCode($request->get('code'));

		if (!$apply)
		{
			return [
				'success' => false,
				'message' => 'Промокод не найден',
			];
		}

		return [
			'success' => true,
			...$this->getCartData($request)
		];
	}


	public function clearPromoCode(Request $request)
	{
		$request->cart->clearPromoCode();

		return [
			'success' => true,
			...$this->getCartData($request)
		];
	}


}
