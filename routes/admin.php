<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin.role:editor'])
    ->group(function () {

    Route::get('/', function () {
        return redirect(route('admin.dashboard'));
    });

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('users', 'UserController')->except(['create','store']);
    Route::post('users/{user}/verify', 'UserController@verify')->name('users.verify');

    Route::resource('media', 'MediaController')->only(['store','destroy']);


    // Route::middleware(['admin.category'])
    //     ->group(function () {
    //         Route::resource('categories', 'CategoryController')->except('show');
    //         Route::post('categories/sort', 'CategoryController@sort')->name('categories.sort');
    // });

    // Route::resource('products', 'ProductController')->except(['show']);
    // Route::post('products/sort', 'ProductController@sort')->name('products.sort');


    // Route::resource('pages', 'PageController')->except(['show']);


    // Route::resource('product_orders', 'ProductOrderController')->only(['index', 'show', 'update']);
    // Route::resource('feedback_orders', 'FeedbackOrderController')->only(['index', 'destroy']);


    Route::middleware(['admin.role:admin'])->group(function () {
        Route::resource('props', 'PropController')->except('show');
        Route::post('props/sort', 'PropController@sort')->name('props.sort');

        Route::get('optimize', function () {
            Artisan::call('optimize:clear');
            Artisan::call('optimize');
            return back();
        })->name('optimize');
    });


    // проверка внешнего вида писем
    Route::prefix('mail')->group(function () {

        Route::get('product/{id?}', function ($id = null) {
            $invoice = App\Models\Order::isPaid()->latest();
            $invoice = $id ? $invoice->findOrFail($id) : $invoice->first();
            return new App\Mail\ProductOrderPaid($invoice, null);
        });
    });

});


require __DIR__.'/auth.php';
