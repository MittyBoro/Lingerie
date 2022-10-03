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

		$cart_count = \Cart::getContent()->count();

		if ($view->__isset('map_addresses')) {
			if ($viewName == 'home')
				$props['map_addresses'] = array_merge($view->__get('map_addresses'), $props['map_addresses']);
			else
				$props['map_addresses'] = $view->__get('map_addresses');
		}



		$view->with([
			'view_name'  => $viewName,
			'props'     => $props,
			'cart_count' => $cart_count,
		]);
	}
}
