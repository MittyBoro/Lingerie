<?php

namespace App\Payments;

use App\Models\Order;
use App\Contracts\PaymentInterface;

class ReceiptPayment implements PaymentInterface
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function charge()
    {
        $this->order->setStatus(self::STATUS_SUCCESS);
    }

    public function check()
    {
        $this->order->setStatus(self::STATUS_SUCCESS);
    }

    public function webhook() {}

    public function redirectUrl() {}

}
