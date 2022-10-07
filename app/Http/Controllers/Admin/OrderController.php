<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;
use App\Services\Payment\Payment;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::orderByDesc('id')
                            ->with(['items', 'bonus', 'user'])
                            ->filter($request->all())
                            ->paginated(['old_amount', 'discounts']);

        $sales = [
            'month' => Order::filter($request->all())->month()->sumAndCount()->first(),
            'year' => Order::filter($request->all())->year()->sumAndCount()->first(),
            'all' => Order::filter($request->all())->sumAndCount()->first(),
        ];

        $user = User::find($request->user_id);

        return Inertia::render('Orders/Index', [
            'list' => $orders,
            'sales' => $sales,
            'user' => $user,
        ]);
    }
    public function show(Order $productOrder)
    {
        $productOrder->load(['items', 'bonus', 'user']);
        $productOrder->setAppends(['old_amount', 'discounts']);

        return Inertia::render('Orders/Show', [
            'item' => $productOrder,
        ]);
    }

    public function update(Request $request, Order $productOrder)
    {
        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(Order::statuses())]
        ]);

        $productOrder->load(['items']);



        if ($data['status'] == Order::STATUS_REFUNDED) {
            try {
                $payment = new Payment($productOrder->payment_type);
                // $payment->refund($productOrder);

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
