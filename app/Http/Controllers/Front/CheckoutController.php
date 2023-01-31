<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function index(Request $request)
    {
        $count = app('CartService')->count();
        if (!$count)
            return redirect('/');

        return view('pages.checkout');
    }


}
