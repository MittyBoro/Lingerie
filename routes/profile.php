<?php

use Illuminate\Support\Facades\Route;

Route::prefix('profile')
	->name('profile.')
	->middleware(['auth', 'verified'])
	->namespace('Front\Profile')
	->group(function () {

		Route::get('/', 'ProfileController@show')->name('show');
		Route::get('/bonuses', 'ProfileController@bonuses')->name('bonuses');

		Route::get('/edit', 'ProfileController@edit')->name('edit');
		Route::post('/edit', 'ProfileController@update')->name('update');

		Route::get('/order/{order}', 'OrderController@show')->name('order');

});


