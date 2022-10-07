<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product\ProductOrder;
use App\Services\Payment\Payment;
use Illuminate\Validation\Rule;

use Propaganistas\LaravelPhone\PhoneNumber;

class CheckoutController extends Controller
{
    public function get(Request $request)
    {
        return [
            ...$this->getTotalData($request),
        ];
    }

    public function applyBonuses(Request $request)
    {
        $bonusLmit = $request->cart->getBonusLimit($request->user()->bonuses);

        $request->validate([
            'bonuses' => 'integer|min:0|max:' . $bonusLmit,
        ]);

        $request->cart->applyCartBonuses($request->bonuses);

        return [
            ...$this->getTotalData($request),
        ];

    }

    private function getTotalData(Request $request): array
    {
        $total = $request->cart->getTotal();
        $bonusLmit = $request->cart->getBonusLimit($request->user()->bonuses);
        $cartBonuses = $request->cart->getCartBonuses();

        return [
            'total'      => $total,
            'bonus_limit' => $bonusLmit,
            'spending_bonuses' => $cartBonuses,
        ];
    }

    public function pay(Request $request)
    {
        if ($request->total != $request->cart->getTotal()) {
            logger()->error('Несовпадение итоговой суммы',
                            [$request->total, $request->cart->getTotal()]);
            return [
                'success' => false,
                'message' => 'Несовпадение итоговой суммы. Обновите страницу и повторите попытку',
            ];
        }

        if ($request->phone)
            $request->merge(['phone' => PhoneNumber::make($request->phone)->formatE164()]);

        $data = $request->validate([
            'name'    => 'string',
            'phone'   => 'string',
            'email'   => 'email|required',

            'address.region' => 'required|string',
            'address.city' => 'required|string',
            'address.street' => 'required|string',
            'address.postcode' => 'nullable',
            'address.transport' => 'string|nullable',

            'comment'   => 'string|nullable',

            'payment_type' => [ 'string', Rule::in(config('payment.types'),) ],
        ]);

        $data += [
            'amount' => $request->cart->getTotal(),
            'delivery' => $request->cart->getCartDelivery(),
            'promocode' => $request->cart->getPromoCode(),
            'spent_bonuses' => abs($request->cart->getCartBonuses()),

            'user_id' => $request->user()->id,
        ];

        $items = $request->cart->creatableList();

        $order = ProductOrder::createOrder($data, $items);

        if (!$order) {
            return [
                'success' => false,
                'message' => 'Ошибка создания платежа, повторите попытку',
            ];
        }

        try {
            return (new Payment($data['payment_type']))->create($order);
        } catch (\Throwable $e) {
            $order->delete();
            throw $e;
        }
    }

}
