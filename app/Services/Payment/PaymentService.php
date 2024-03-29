<?php

namespace App\Services\Payment;

use App\Contracts\PaymentInterface;
use App\Models\Order;
use App\Payments\DefaultPayment;

class PaymentService
{
    public static function set(Order|null $order, string|null $type = null): PaymentInterface
    {
        $paymentType = $type ?? $order->getPaymentType();

        $modelClass = config('payment.drivers.' . $paymentType . '.class');

        if (!class_exists($modelClass))
            return new DefaultPayment($order);

        return new $modelClass($order);
    }

}
