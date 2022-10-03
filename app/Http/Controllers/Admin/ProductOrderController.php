<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PartnerRequest;
use Illuminate\Http\Request;

use App\Models\Product\ProductOrder;
use App\Models\User;
use App\Services\Payment\Payment;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProductOrderController extends Controller
{
	public function index(Request $request)
	{
		$orders = ProductOrder::orderByDesc('id')
							->with(['items', 'bonus', 'user'])
							->filter($request->all())
							->paginated(['old_amount', 'discounts']);

		$sales = [
			'month' => ProductOrder::filter($request->all())->month()->sumAndCount()->first(),
			'year' => ProductOrder::filter($request->all())->year()->sumAndCount()->first(),
			'all' => ProductOrder::filter($request->all())->sumAndCount()->first(),
		];

		$user = User::find($request->user_id);

		return Inertia::render('ProductOrders/Index', [
			'list' => $orders,
			'sales' => $sales,
			'user' => $user,
		]);
	}
	public function show(ProductOrder $productOrder)
	{
		$productOrder->load(['items', 'bonus', 'user']);
		$productOrder->setAppends(['old_amount', 'discounts']);

		return Inertia::render('ProductOrders/Show', [
			'item' => $productOrder,
		]);
	}

	public function update(Request $request, ProductOrder $productOrder)
	{
		$data = $request->validate([
			'status' => ['required', 'string', Rule::in(ProductOrder::statuses())]
		]);

		$productOrder->load(['items']);



		if ($data['status'] == ProductOrder::STATUS_REFUNDED) {
			try {
				$payment = new Payment($productOrder->payment_type);
				$payment->refund($productOrder);

			} catch (\Throwable $th) {
				return back()->withErrors([
					'message' => $th->getMessage(),
				]);
			}
		}

		$productOrder->update($data);

		return back();
	}

}
