<?php

namespace App\Http\Controllers\Front\Cart;

use App\Http\Controllers\Front\Controller;
use App\Http\Controllers\Front\Traits\PageTrait;
use App\Models\Product\ProductOrder;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
	use PageTrait;

	public function index(Request $request)
	{
		$request->cart->recalculateCart();

		$page = $this->getPage('checkout');

		$cart = $request->cart->list();

		if (!$cart->count()) {
			return redirect('/cart');
		}

		$customer = $this->getCustomer($request);

		$promocode = $request->cart->getPromoCode();
		$subtotal = $request->cart->getSumWithoutDiscount();
		// $subtotal = $request->cart->getSubTotal();
		$discount = $subtotal - $request->cart->getSubTotal();

		$delivery = $request->cart->getCartDelivery();
		$futureBonuses = $request->cart->getFutureBonuses();

		// $total = $request->cart->getTotal();

		$bonusLmit = $request->cart->getBonusLimit($request->user()->bonuses);

		return view('pages.checkout', [
			'page' => $page,
			'customer' => $customer,

			'cart'      => $cart,
			'promocode' => $promocode,
			'delivery'  => $delivery,
			'discount'  => $discount,
			'subtotal'  => $subtotal,
			'futureBonuses'   => $futureBonuses,

			'bonusLimit' => $bonusLmit,

			// 'total'     => $total,
		]);
	}

	private function getCustomer(Request $request)
	{
		$lastOrder = ProductOrder::latest()
							->where('user_id', $request->user()->id)
							->first();

		if ( $lastOrder ) {
			$customer = [
				'name' => $lastOrder->name,
				'email' => $lastOrder->email,
				'phone' => $lastOrder->phone,

				'region' => $lastOrder->address['region'],
				'city' => $lastOrder->address['region'],
				'street' => $lastOrder->address['street'],
				'postcode' => $lastOrder->address['postcode'],
				'transport' => $lastOrder->address['transport'],
			];
		} else {
			$customer = [
				'name' => $request->user()->name,
				'email' => $request->user()->email,
				'phone' => $request->user()->phone,
			];
		}

		return $customer;
	}


}
