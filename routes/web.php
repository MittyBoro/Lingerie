<?php

use Illuminate\Support\Facades\Route;


Route::get('payment/webhook/{payment_type}', 'PaymentController@webhook')->name('payment.webhook');


Route::middleware('locale')
    ->name('front.')
    ->namespace('Front')
    ->group(function () {

    Route::post('locale', fn () => back())->name('locale');

    Route::prefix('/{lang?}')->group(function () {

        Route::middleware('page')->group(function () {

            Route::get('/', 'HomeController@index')->name('home');
            Route::get('catalog', 'CatalogController@index')->name('catalog');
            Route::get('categories/{slug?}', 'CatalogController@categories')
                                ->name('categories');

            Route::get('product/{slug?}', 'ProductController@index')->name('products');

            Route::get('orders/{order:uuid}', 'OrderController@index')->name('orders');

            Route::get('faq', 'FAQController@index')->name('faq');


            // все вставлять до этого!
            Route::get('{path}',  'PageController@index')->where('path', '.*')->name('pages');
        });
    });

});

