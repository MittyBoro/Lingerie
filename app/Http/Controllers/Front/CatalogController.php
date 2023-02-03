<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    public function index(Request $request)
    {
        $content = $this->content($request);

        return view('pages.catalog', [
            'slug' => '',
            ...$content,
        ]);
    }

    public function categories(Request $request)
    {
        $category = ProductCategory::findForFront($request->slug, locale());

        $page = $this->replacePageData($request->get('page'), $category);
        $page->title = $category->title;

        $content = $this->content($request, $category->id);

        return view('pages.catalog', [
            'page' => $page,
            'slug' => $request->slug,
            ...$content,
        ]);
    }

    private function content(Request $request, $categoryId = null)
    {
        $data = $request->all();
        $data['categories'] = $categoryId;

        $products = Product::getCatalog(locale(), $data);

        $pricesRange = Product::minMaxPrice(locale());

        $options = ProductOption::getPublic()->toArray();

        return [
            'products' => $products,
            'options' => $options,
            'pricesRange' => $pricesRange,
            'sort' => $request->get('sort'),
        ];
    }


}
