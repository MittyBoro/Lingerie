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
                    'route' => 'admin.products.index',
                    // 'query' => [ 'type' => 'products' ],
                ],
                [
                    'name' => 'Группы атрибутов',
                    'route' => 'admin.products.index',
                ],
                [
                    'name' => 'Атрибуты',
                    'route' => 'admin.products.index',
                ],
            ],
        ],
        [
            'name' => 'Заказы',
            'route' => 'admin.products.index',
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
                    'name' => 'Основное',
                    'route' => 'admin.props.index',
                ],
                [
                    'name' => 'FAQ',
                    'route' => 'admin.faqs.index',
                ],
            ],
        ],

    ],
];
