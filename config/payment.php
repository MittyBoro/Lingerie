<?php

return [

    'yookassa' => [
        'shop_id' => env('YOO_SHOP_ID', null),
        'secret_key' => env('YOO_SECRET_KEY', null),
    ],

    'types' => [
        'yookassa',
        'receipt',
    ],
];
