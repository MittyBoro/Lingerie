<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cart')
    ->name('cart.')
    ->namespace('Cart')
    ->group(function () {

        Route::controller('CartController')
            ->group(function () {
            Route::get('get', 'get')->name('get');
            Route::post('add', 'add')->name('add');
            Route::post('update', 'update')->name('update');
            Route::post('remove', 'remove')->name('remove');

            Route::post('promocode/apply', 'applyPromoCode')->name('promocode.apply');
            Route::post('promocode/clear', 'clearPromoCode')->name('promocode.clear');
        });

        Route::prefix('checkout')
            ->name('checkout.')
            ->controller('CheckoutController')
            ->middleware(['auth'])
            ->group(function () {
            Route::get('get', 'get')->name('get');
            Route::post('bonuses', 'applyBonuses')->name('bonuses');
            Route::post('pay', 'pay')->name('pay');
        });


});

Route::prefix('order')
    ->name('order.')
    ->group(function () {

    Route::post('feedback', 'FeedbackOrderController@create')->name('feedback.create');
});
