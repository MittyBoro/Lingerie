<?php

namespace App\Providers;

use App\View\Composers\MainComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer([
			'pages.*',
			'auth.*',
			'profile.*',
			'layouts.email',
			'errors::404',
		], MainComposer::class);
	}
}
