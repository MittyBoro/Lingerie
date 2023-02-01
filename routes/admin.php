<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['admin.role:editor'])
    ->group(function () {

    Route::get('/', function () {
        return redirect(route('admin.dashboard'));
    });

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('admin_lang', 'Controller@setListLang')->name('admin_lang.set');

    Route::resource('users', 'UserController')->except(['create','store','show']);
    Route::post('users/{user}/verify', 'UserController@verify')->name('users.verify');

    Route::resource('media', 'MediaController')->only(['store','destroy']);



    Route::resource('pages', 'PageController');

    Route::resource('faqs', 'FAQController')->except(['show']);
    Route::resource('translations', 'TranslationController')->only(['index','create','update','destroy']);



    Route::resource('products', 'ProductController');
    Route::post('products/sort', 'ProductController@sort')->name('products.sort');

    Route::resource('product_options', 'ProductOptionController')
                            ->only(['index','create','update','destroy']);
    Route::post('product_options/sort', 'ProductOptionController@sort')
                            ->name('product_options.sort');

    Route::resource('product_categories', 'ProductCategoryController');
    Route::post('product_categories/sort', 'ProductCategoryController@sort')->name('product_categories.sort');

    Route::resource('orders', 'OrderController')->only(['index', 'update']);




    // Route::resource('feedback_orders', 'FeedbackOrderController')->only(['index', 'destroy']);



    Route::post('faqs/sort', 'FAQController@sort')->name('faqs.sort');


    Route::middleware(['admin.role:admin'])->group(function () {
        Route::resource('props', 'PropController')->except('show');
        Route::post('props/update_list', 'PropController@updateList')->name('props.update_list');


        Route::get('optimize', function () {
            Artisan::call('optimize:clear');

            if (config('app.environment') == 'production')
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
