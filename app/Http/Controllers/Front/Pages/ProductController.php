<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $slug = $request->route('any2');

        $product = Product::with([
                                'categories' => function ($cat) {
                                    $cat->whereIsRoot();
                                },
                                'variations' => function ($v) {
                                    $v->select('id', 'product_id', 'name', 'bonuses', 'price', 'value');
                                },
                                'media', 'variations'])
                            ->whereSlug($slug)
                            ->first();

        if (!$product) {
            return redirect('/shop');
        }

        $product = $product->append('gallery', 'json');

        $similar = Cache::remember('post_similar_' . $product->id, 60 * 60, function() use ($product) {
            return Product::with('media')
                            ->where('id', '!=', $product->id)
                            ->publicCatalog()
                            ->isStock()
                            ->withPrice()
                            ->inRandomOrder($product->id)
                            ->limit(4)->get();
        });

        if (!filled($product->meta_description)) {
            $this->replacePageKey('meta_description', $product->meta_title, '%meta_title%');
        }

        $this->replacePageData($product);

        $priceText = $product->current_price . ' руб';
        $this->replacePageData($priceText, '%price%');

        return view('pages.product', [
            'page' => $this->page,
            'product' => $product,
            'similar' => $similar,
            'category' => $product->categories->last(),
        ]);
    }

}
