<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all();
        $data['categories'] = $request->slug ? ProductCategory::findForFront($request->slug, locale()) : null;

        $products = Product::getCatalog(locale(), $data);

        return view('elements.catalog_list', [
            'products' => $products,
        ]);
    }

}
