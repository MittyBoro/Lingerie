<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CatalogController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::getFrontList($this->getLang());
        /*
            products
            colors
            min/max price
            sizes
        */



        return view('pages.catalog', [
            'products' => $products,
        ]);
    }

    public function categories(Request $request)
    {
        $page = $request->page;



        return view('pages.catalog');
    }
}
