<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product\Product;
use App\Models\Product\ProductOrder;
use App\Models\FeedbackOrder;
use App\Models\Partner;
use App\Models\Post;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		/**
		 * Заказы
		 * Обратная связь
		 * Товары
		 * Новости
		 * Партнёры (дистриб/франч)
		 */

		// $orderFK = array_flip(array_keys(FeedbackOrder::FORM_TYPES));

		// $data = [
		// 	'orders' => [
		// 		'title' =>'Заказы товаров',
		// 		'route' => 'admin.product_orders.index',
		// 		'info' => ProductOrder::sumAndCount()->first(),
		// 		'week_info' => ProductOrder::week()->sumAndCount()->first(),
		// 		'month_info' => ProductOrder::month()->sumAndCount()->first(),
		// 		'half_year_info' => ProductOrder::halfYear()->sumAndCount()->first(),
		// 		'year_info' => ProductOrder::year()->sumAndCount()->first(),
		// 	],
		// 	'order_forms' => [
		// 		'title' =>'Обратная связь',
		// 		'route' => 'admin.feedback_orders.index',
		// 		'count' => FeedbackOrder::count(),
		// 		'forms' => FeedbackOrder::selectRaw('form, count(*) as count')
		// 						->groupBy('form')->get()
		// 						->sortBy([
		// 							fn ($a, $b) => $orderFK[$a['form']] <=> $orderFK[$b['form']],
		// 						]),
		// 	],
		// 	'products' => [
		// 		'title' =>'Товары',
		// 		'route' => 'admin.products.index',
		// 		'count' => Product::isPublished()->count(),
		// 	],
		// 	'news' => [
		// 		'title' =>'Блог',
		// 		'route' => 'admin.posts.index',
		// 		'count' => Post::isPublished()->count(),
		// 	],
		// 	'partners' => [
		// 		'title' =>'Партнёры',
		// 		'route' => 'admin.partners.index',
		// 		'count' => Partner::isPublished()->count(),
		// 		'count_franchisee' => Partner::isPublished()->franchisee()->count(),
		// 		'count_distributors' => Partner::isPublished()->distributors()->count(),
		// 	],
		// ];
        $data = [];
		return Inertia::render('Dashboard/Index', [
			'data' => $data,
			'data' => $data,
		]);
	}
}
