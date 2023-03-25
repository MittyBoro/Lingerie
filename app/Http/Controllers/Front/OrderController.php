<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Services\Payment\PaymentService;

class OrderController extends Controller
{
    public function index(Order $order)
    {

        if ($order->status == Order::STATUS_PENDING) {
            $payemnt = PaymentService::set($order);
            $order->redirect_url = $payemnt->redirectUrl();
            $payemnt->check();
        }

        return view('pages.order', [
            'order' => $order,
        ]);
    }
}
