<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CatalogController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::getFrontList($this->getLang());


        return view('pages.catalog', [
            'products' => $products,
            'slug' => '',
            ...$this->sidebarData(),
        ]);
    }

    public function categories(Request $request, $slug)
    {
        $category = ProductCategory::findForFront($slug, $this->getLang());
        $products = Product::whereCategory($category->id)->getFrontList($this->getLang());

        $page = $this->replacePageData($request->get('page'), $category);

        return view('pages.catalog', [
            'products' => $products,
            'page' => $page,
            'slug' => $slug,
            ...$this->sidebarData(),
        ]);
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
