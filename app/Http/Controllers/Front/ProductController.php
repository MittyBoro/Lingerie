<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $slug)
    {
        $product = Product::frontBySlug($slug, $this->getLang());
        dd($product->toArray());

        $page = $this->replacePageData($request->get('page'), $product);
        $page->title = $product->title;

        return view('pages.product', [
            'product' => $product,
            'page' => $page,
        ]);
    }
}
