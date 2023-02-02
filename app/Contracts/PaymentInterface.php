<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentInterface extends PaymentStatusInterface
{

    public function __construct(Order $order);

    public function charge();

    // public function refund($amount);

    public function check();

    public function webhook();


    public function redirectUrl();

}
