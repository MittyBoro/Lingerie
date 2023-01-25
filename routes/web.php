<?php

use Illuminate\Support\Facades\Route;




Route::name('front.')->namespace('Front')->group(function () {

        // Route::view('/', 'pages.home');
        // Route::view('catalog', 'pages.catalog');
        // Route::view('product', 'pages.product');
        // Route::view('cart', 'pages.cart');
        // Route::view('checkout', 'pages.checkout');
        // Route::view('page', 'pages.page');
        // Route::view('faq', 'pages.faq');
        // Route::view('success', 'pages.success');
        // Route::view('404', 'pages.404');

        // Route::view('category', 'pages.shop.catalog');

    // Route::namespace('Cart')->group(function () {
    //     Route::middleware(['auth'])->get('checkout', 'CheckoutController@index')->name('checkout');

    //     Route::any('payment/webhook/{type}', 'PaymentController@webhook')->name('payment.webhook');
    //     Route::middleware(['auth'])->any('payment/return/{order}', 'PaymentController@return')->name('payment.return');
    // });

    // Route::get('search', 'SearchController@index')->name('search');
    Route::get('/locale/{locale}', fn () => back())->name('locale');


    /*
        home     DefaultController
        catalog  CatalogController
        product  ProductController
        cart     DefaultController
        checkout DefaultController
        page     DefaultController
        faq      FAQController
        success  DefaultController
     */


    Route::middleware('only_page')->group(function () {

        Route::get('catalog',     'CatalogController@index');
        Route::get('categories/{product_categories:slug}',     'CatalogController@categories');

        Route::get('product',     'ProductController@index');
        Route::get('faq',         'FAQController@index');
        Route::get('{path}', 'PageController@index')->where('path', '.*');

    });



    // Route::get('{page?}/{any2?}/{any3?}', 'FrontController')->name('pages');
});


// php artisan make:controller Front\DefaultController
// php artisan make:controller Front\CatalogController
// php artisan make:controller Front\ProductController
// php artisan make:controller Front\FAQController
