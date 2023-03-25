<?php

return [

    'available_drivers' => explode(',', env('AVAILABLE_PAYMENT_DRIVERS', 'receipt')),

    'drivers' => [
        // 'yookassa' => [
        //     'class' => \App\Payments\YooKassaPayment::class,

        //     'shop_id' => env('YOO_SHOP_ID', null),
        //     'secret_key' => env('YOO_SECRET_KEY', null),
        // ],
        'freekassa' => [
            'class' => \App\Payments\FreeKassaPayment::class,

            'shop_id' => env('FREEKASSA_SHOP_ID', null),
            'api_key' => env('FREEKASSA_API_KEY', null),
        ],
        'receipt' => [
            'class' => \App\Payments\ReceiptPayment::class,
        ],
    ],
];
