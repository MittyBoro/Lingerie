<?php

namespace App\Http\Controllers\Front\Pages;

use App\Models\Partner;
use App\Models\Post;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('media')
                            ->publicCatalog()
                            ->withPrice()
                            ->latest()
                            ->limit(4)
                            ->get();

        $news = Post::with('media')
                    ->publicPosts()
                    ->latest()
                    ->limit(4)
                    ->get();

        $mapAddresses = Partner::franchiseeAdresses()->toArray();

        return view('pages.home', [
            'page' => $this->page,
            'map_addresses' => $mapAddresses,
            'products' => $products,
            'news' => $news,
        ]);
    }
}
