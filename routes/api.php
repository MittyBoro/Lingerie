<?php

use Illuminate\Support\Facades\Route;

Route::middleware('locale')->group(function () {

    Route::prefix('/{lang}')->group(function () {

        Route::prefix('cart')
            ->name('cart.')
            ->group(function () {

            Route::controller('CartController')
                ->group(function () {
                Route::get('get', 'index')->name('get');
                Route::post('store/{id}', 'store')->name('store');
                Route::post('update/{cart_id}', 'update')->name('update');
                Route::post('destroy/{cart_id}', 'destroy')->name('destroy');
                Route::get('final', 'final')->name('final');
            });

            Route::post('checkout', 'CheckoutController@store')->name('checkout');

        });

        Route::post('catalog/{slug?}', 'CatalogController@index')->name('catalog');

    });
});
