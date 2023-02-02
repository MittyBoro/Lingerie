<?php

use App\Models\User;

return [

    'url' => env('APP_URL', 'http://localhost'),

    'path' => env('ADMIN_PATH', '@theadmin'),

    'menu' => [
        [
            'name' => 'Главная',
            'route' => 'admin.dashboard',
            'icon' => 'house',
        ],

        [
            'name' => 'Магазин',
            'icon' => 'store',
            'route' => 'admin.products.index',
            'sublinks' => [
                [
                    'name' => 'Товары',
                    'route' => 'admin.products.index',
                ],
                [
                    'name' => 'Категории',
                    'route' => 'admin.product_categories.index',
                    // 'query' => [ 'type' => 'products' ],
                ],
                [
                    'name' => 'Варианты',
                    'route' => 'admin.product_options.index',
                ],
            ],
        ],
        [
            'name' => 'Заказы',
            'route' => 'admin.orders.index',
            'icon' => 'cart-shopping',
        ],
        [
            'name' => 'Страницы',
            'route' => 'admin.pages.index',
            'icon' => 'note-sticky',
        ],
        [
            'name' => 'Пользователи',
            'route' => 'admin.users.index',
            'icon' => 'users-gear',
            'role_except' => [User::ROLE_EDITOR],
        ],
        [
            'name' => 'Дополнительно',
            'icon' => 'gear',
            'role_except' => [User::ROLE_EDITOR],
            'route' => 'admin.props.index',
            'sublinks' => [
                [
                    'name' => 'Параметры',
                    'route' => 'admin.props.index',
                ],
                // [
                //     'name' => 'Переводы',
                //     'route' => 'admin.translations.index',
                // ],
                [
                    'name' => 'FAQ',
                    'route' => 'admin.faqs.index',
                ],
                [
                    'name' => 'Очистить кэш',
                    'route' => 'admin.optimize',
                    'role_except' => [User::ROLE_EDITOR],
                ],
            ],
        ],

    ],
];
