<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cart')
    ->name('cart.')
    ->group(function () {

    Route::controller('CartController')
        ->group(function () {
        Route::get('get', 'index')->name('get');
        Route::post('store/{id}', 'store')->name('store');
        Route::post('update/{cart_id}', 'update')->name('update');
        Route::post('destroy/{cart_id}', 'destroy')->name('destroy');
    });

});


Route::post('catalog/{slug?}', 'CatalogController@index')->name('catalog');

//         Route::prefix('checkout')
//             ->name('checkout.')
//             ->controller('CheckoutController')
//             ->middleware(['auth'])
//             ->group(function () {
//             Route::get('get', 'get')->name('get');
//             Route::post('bonuses', 'applyBonuses')->name('bonuses');
//             Route::post('pay', 'pay')->name('pay');
//         });



// Route::prefix('order')
//     ->name('order.')
//     ->group(function () {

//     Route::post('feedback', 'FeedbackOrderController@create')->name('feedback.create');
// });
