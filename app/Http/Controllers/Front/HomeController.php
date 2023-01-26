<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::limit(10)
                           ->getFrontList($this->getLang(), false, 'preview');

        $categories = ProductCategory::getFrontParentList($this->getLang());


        return view('pages.home', [
            'products' => $products,
            'homeCategories' => $categories,
        ]);
    }
}
