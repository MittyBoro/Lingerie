<?php

use Illuminate\Support\Facades\Route;




Route::name('front.')
    ->namespace('Front')
    ->group(function () {

        Route::view('/', 'pages.home');
        Route::view('catalog', 'pages.shop.catalog');
        Route::view('product', 'pages.shop.product');
        Route::view('cart', 'pages.shop.cart');
        Route::view('checkout', 'pages.shop.checkout');
        Route::view('page', 'pages.page');
        Route::view('faq', 'pages.faq');
        Route::view('success', 'pages.shop.success');
        Route::view('404', 'pages.404');

        // Route::view('category', 'pages.shop.catalog');

    // Route::namespace('Cart')->group(function () {
    //     Route::middleware(['auth'])->get('checkout', 'CheckoutController@index')->name('checkout');

    //     Route::any('payment/webhook/{type}', 'PaymentController@webhook')->name('payment.webhook');
    //     Route::middleware(['auth'])->any('payment/return/{order}', 'PaymentController@return')->name('payment.return');
    // });

    // Route::get('search', 'SearchController@index')->name('search');

    // Route::get('{any?}/{any2?}/{any3?}', 'PageController@index')->name('pages');

    Route::get('/locale/{locale}', fn () => back())->name('locale');
});
