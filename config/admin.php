<?php

use App\Models\User;

return [

    'url' => env('APP_URL', 'http://localhost'),

	'path' => env('ADMIN_PATH', '@theadmin'),

	'menu' => [
		[
			'name' => 'Главная',
			'route' => 'admin.dashboard',
			'icon' => 'gauge-high',
		],

		[
			'name' => 'Заказы товаров',
			'route' => 'admin.product_orders.index',
			'icon' => 'cart-shopping',
		],
		[
			'name' => 'Обратная связь',
			'route' => 'admin.feedback_orders.index',
			'icon' => 'headset',
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
					'route' => 'admin.categories.index',
					'query' => [ 'type' => 'products' ],
				],
				[
					'name' => 'Промокоды',
					'route' => 'admin.promo_codes.index',
				],
			],
		],
		[
			'name' => 'Партнёры',
			'route' => 'admin.partners.index',
			'icon' => 'handshake',
		],
		[
			'name' => 'Страницы',
			'route' => 'admin.pages.index',
			'icon' => 'note-sticky',
		],
		[
			'name' => 'Блог',
			'route' => 'admin.posts.index',
			'icon' => 'newspaper',
		],
		[
			'name' => 'Пользователи',
			'route' => 'admin.users.index',
			'icon' => 'users-gear',
			'role_except' => [User::ROLE_EDITOR],
		],
		[
			'name' => 'Бонусы',
			'route' => 'admin.bonuses.index',
			'icon' => 'gift',
			'role_except' => [User::ROLE_EDITOR],
		],
		[
			'name' => 'Дополнительно',
			'route' => 'admin.props.index',
			'icon' => 'gear',
			'role_except' => [User::ROLE_EDITOR],
		],
	],
];
