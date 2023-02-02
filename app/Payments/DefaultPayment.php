<?php

namespace App\Payments;

use App\Models\Order;
use App\Contracts\PaymentInterface;

class DefaultPayment implements PaymentInterface
{
    public function __construct(Order $order){}

    public function charge() {}

    public function check() {}

    public function webhook() {}

    public function redirectUrl() {}

}
