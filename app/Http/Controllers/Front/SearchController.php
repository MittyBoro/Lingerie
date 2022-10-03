<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Product\Product;

class SearchController extends Controller
{

	public function index(Request $request)
	{
		$q = $request->get('q');
		if (!$q)
			abort(404);

		$countPerPage = 4;

		$posts = Post::with('media')
					->publicPosts()
					->setPerPage($countPerPage)
					->search($q)
					->orderByDesc('relevance')
					->paginated();

		$products = Product::with('media')
					->publicCatalog()
					->setPerPage($countPerPage)
					->search($q)
					->orderByDesc('relevance')
					->withPrice()
					->paginated();

		return view('pages.search', [
			'posts' => $posts,
			'products' => $products,
			'q' => $q,
		]);
	}


}
