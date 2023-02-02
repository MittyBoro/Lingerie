<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CheckoutController extends Controller
{

    public function store(Request $request)
    {
        $data = [
            'items' => app('CartService')->totalItems(), // обновит данные по прайсу, если надо
            'amount' => app('CartService')->total(),     // и получит их
            'cart_id' => app('CartService')->cartId(),
            'currency' => config('app.currency'),
        ];

        // и можно сравнить, если с товарами что-то изменилось
        if ($data['amount'] != $request->get('total')) {
            return [
                'url' => '/checkout?error=total',
            ];
        }

        $data += $request->validate([
            'name'    => 'string|required',
            'phone'   => 'string|required',
            'email'   => 'email|required',

            'address.country' => 'required|string',
            'address.region' => 'required|string',
            'address.city' => 'required|string',
            'address.street' => 'required|string',
            'address.postcode' => 'nullable',

            'comment'   => 'string|nullable',

            'payment_type' => [ 'string', Rule::in( array_keys(config('payment.drivers')) ) ],
        ]);


        $order = Order::createOrder($data);

        if (!$order) {
            abort(500);
        }

        $payemnt = PaymentService::set($order);
        $payemnt->charge();

        return [
            'url' => $payemnt->redirectUrl() ?: route('front.order', $order->uuid)
        ];
    }

}
