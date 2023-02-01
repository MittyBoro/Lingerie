<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class CheckoutController extends Controller
{

    public function store(Request $request)
    {
        // данные по  пройсу обновятся
        $data = [
            'items' => app('CartService')->totalItems(),
            'amount' => app('CartService')->total(),
            'currency' => config('app.currency'),
        ];

        // и можно сравнить, если с товарами что-то изменилось
        if ($data['amount'] != $request->get('total')) {
            return [
                'url' => '/checkout',
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

            'payment_type' => [ 'string', Rule::in(config('payment.types'),) ],
        ]);

        $result = Order::createOrder($data);

        if ($result) {
            return [
                'url' => route('front.order', $result->uuid)
            ];
        }

        abort(500);
    }

}
