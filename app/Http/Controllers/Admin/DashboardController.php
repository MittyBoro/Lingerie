<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\Order;
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

        $data = [
            'products' => [
                'title' =>'Товары',
                'route' => 'admin.products.index',
                'count' => Product::isPublished()->count(),
                'count_month' => Product::month()->isPublished()->count(),
                'count_half_year' => Product::halfYear()->isPublished()->count(),
                'count_year' => Product::year()->isPublished()->count(),
                'count_categories' => ProductCategory::count(),
            ],
            'orders' => [
                'title' =>'Заказы',
                'route' => 'admin.orders.index',
                'info' => Order::sumAndCount()->first(),
                'week_info' => Order::week()->sumAndCount()->first(),
                'month_info' => Order::month()->sumAndCount()->first(),
                'half_year_info' => Order::halfYear()->sumAndCount()->first(),
                'year_info' => Order::year()->sumAndCount()->first(),
            ],
        ];

        return Inertia::render('Dashboard/Index', [
            'data' => $data,
        ]);
    }
}
