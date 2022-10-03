<?php

namespace App\Http\Controllers\Front\Profile;

use App\Http\Controllers\Front\Controller;
use App\Models\Product\ProductOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{

	public function show(Request $request, $order_id)
	{
		$order = ProductOrder::with('items')
						->when(!$request->user()->is_admin, function($query) use ($request) {
							$query->user($request->user()->id);
						})
						->findOrFail($order_id);

		return view('profile.order', [
			'order' => $order,
		]);
	}

}
