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

    public function categories(Request $request, $slug)
    {
        $category = ProductCategory::findForFront($slug, $this->getLang());

        $page = $this->replacePageData($request->get('page'), $category);
        $page->title = $category->title;

        $content = $this->content($request, $category->id);

        return view('pages.catalog', [
            'page' => $page,
            'slug' => $slug,
            ...$content,
        ]);
    }

    private function content(Request $request, $categoryId = null)
    {
        $data = $request->all();
        $data['categories'] = $categoryId;

        $products = Product::getCatalog($this->getLang(), $data);

        $pricesRange = Product::relationByIds('categories', $categoryId)
                              ->relationByIds('options', $request->get('options'))
                              ->minMaxPrice($this->getLang());

        $options = ProductOption::getPublic()->toArray();

        return [
            'products' => $products,
            'options' => $options,
            'pricesRange' => $pricesRange,
            'sort' => $request->get('sort'),
        ];
    }


}
