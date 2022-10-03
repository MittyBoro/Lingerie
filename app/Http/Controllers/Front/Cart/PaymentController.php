<?php

namespace App\Http\Controllers\Front\Cart;

use App\Http\Controllers\Front\Controller;
use App\Models\Product\ProductOrder;
use App\Services\Payment\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function webhook($type)
	{
		if (! in_array($type, config('payment.types')))
			abort(404);

		$payment = new Payment($type);
		$payment->webhook($type);

		return response('Success', 200);
	}

	public function return(Request $request, ProductOrder $order)
	{
		$userOrder = $request->user()?->orders()->find($order->id);

		if (!$userOrder)
			return redirect()->route('profile.show');

		if (!$order->is_paid) {
			$payment = new Payment($order->payment_type);
			$payment->updateStatus($order);
		}

		return redirect()->route('profile.order', $order->id);
	}

}
