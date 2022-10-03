<?php

use Illuminate\Support\Facades\Route;



require __DIR__.'/auth.php';
require __DIR__.'/profile.php';


Route::name('front.')
	->middleware('guest_or_verified')
	->namespace('Front')
	->group(function () {

	Route::namespace('Cart')->group(function () {
		Route::middleware(['auth'])->get('checkout', 'CheckoutController@index')->name('checkout');

		Route::any('payment/webhook/{type}', 'PaymentController@webhook')->name('payment.webhook');
		Route::middleware(['auth'])->any('payment/return/{order}', 'PaymentController@return')->name('payment.return');
	});

	Route::get('search', 'SearchController@index')->name('search');

	Route::get('{any?}/{any2?}/{any3?}', 'PageController@index')->name('pages');
});
