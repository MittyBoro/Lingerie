<?php

namespace App\View\Composers;

use App\Models\Prop;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MainComposer
{
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view_array = explode('.', $view->getName());
        $viewName = end($view_array);

        $props = Cache::remember('view_props', 60 * 60 * 24, function() {
            $props = Prop::list();
            return $props;
        });

        // $cart_count = \Cart::getContent()->count();

        $view->with([
            'view_name'  => $viewName,
            'props'     => $props,
            // 'cart_count' => $cart_count,
        ]);
    }
}
