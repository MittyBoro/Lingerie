<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CatalogController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::getFrontList($this->getLang());


        return view('pages.catalog', [
            'products' => $products,
            ...$this->sidebarData(),
        ]);
    }

    public function categories(Request $request)
    {
        $page = $request->page;

        return view('pages.catalog');
    }


    private function sidebarData(): array
    {
        $attrs = ProductAttribute::getPublic()->toArray();

        $prices = Product::minMaxPrice($this->getLang());

        return [
            'colors' => $attrs['color'],
            'sizes' => $attrs['size'],
            ...$prices->toArray(),
        ];
    }

}
