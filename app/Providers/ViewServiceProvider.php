<?php

namespace App\Providers;

use App\View\Composers\FrontComposer;
use App\View\Composers\CurrencyComposer;

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
            'layouts.email',
            'errors::404',
        ], FrontComposer::class);

        View::composer([
            'elements.catalog_list',
            'pages.*',
            'layouts.email',
            'errors::404',
        ], CurrencyComposer::class);
    }
}
