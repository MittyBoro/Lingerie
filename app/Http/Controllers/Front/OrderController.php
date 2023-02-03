<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request, $lang, Order $order)
    {
        $order->redirect_url = $order->redirectUrl();

        return view('pages.order', [
            'order' => $order,
        ]);
    }
}
