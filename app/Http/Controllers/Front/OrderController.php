<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, Order $order)
    {
        dd($order);

        return view('pages.status', [
            'order' => $order,
        ]);
    }
}
