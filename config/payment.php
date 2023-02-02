<?php

return [

    'drivers' => [
        'yookassa' => [
            'class' => \App\Payments\YooKassaPayment::class,

            'shop_id' => env('YOO_SHOP_ID', null),
            'secret_key' => env('YOO_SECRET_KEY', null),
        ],
        'receipt' => [
            'class' => \App\Payments\ReceiptPayment::class,
        ],
    ],
];
