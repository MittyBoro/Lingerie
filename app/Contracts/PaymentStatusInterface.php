<?php

namespace App\Contracts;


interface PaymentStatusInterface
{

    const STATUS_PENDING  = 'pending';
    const STATUS_SUCCESS  = 'success';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

}
