<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PartnerRequest;
use Illuminate\Http\Request;

use App\Models\FeedbackOrder;

use Inertia\Inertia;

class FeedbackOrderController extends Controller
{

	public function index()
	{
		$orders = FeedbackOrder::orderByDesc('id')
							->paginated();

		return Inertia::render('FeedbackOrders/Index', [
			'list' => $orders,
		]);
	}

	public function destroy(FeedbackOrder $feedback_order)
	{
		$feedback_order->delete();

		return back();
	}
}
