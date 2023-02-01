<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $product = Product::frontBySlug($slug, $this->getLang());

        $page = $this->replacePageData($request->get('page'), $product);
        $page->title = $product->title;

        $cartMini = app('CartService')->getMini();

        return view('pages.product', [
            'page' => $page,
            'product' => $product,
            'cartMini' => $cartMini,
        ]);
    }
}
