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
                            ->with(['items'])
                            ->customPaginate(30);

        $sales = [
            'month' => Order::month()->sumAndCount(),
            'year' => Order::year()->sumAndCount(),
            'all' => Order::sumAndCount(),
        ];

        return Inertia::render('Orders/Index', [
            'list' => $orders,
            'sales' => $sales,
        ]);
    }

    public function update(Request $request, Order $productOrder)
    {
        $data = $request->validate([
            'status' => ['required', 'string', Rule::in(Order::statuses())]
        ]);

        $productOrder->load(['items']);

        $productOrder->update($data);

        return back();
    }

}
