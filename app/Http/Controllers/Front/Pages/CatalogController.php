<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;

use App\Models\Product\Product;
use App\Models\Category;
use App\Services\Cities;

class CatalogController extends Controller
{

	private $category = null;

	public function index(Request $request, $route, $slug = null)
	{
		$this->replacePageDataByRoute($route, $slug);

		$countPerPage = is_desktop() ? 12 : 8;

		if ($route == 'city-shop') {
			$countPerPage = 15;
			$shugarIds = $this->shugarIds();
		} else {
			$shugarIds = null;
		}

		$products = Product::with(['media', 'variations'])
							->priorityIds($shugarIds)
							->publicCatalog($this->category)
							->setPerPage($countPerPage)
							->withPrice()
							->paginated();

		abort_if($products->isEmpty(), 404);

		$categories = Category::getAllCategories(Product::class);

		return view('pages.catalog', [
			'page' => $this->page,
			'products' => $products,
			'categories' => $categories,
			'category' => $this->category,
		]);
	}

	private function replacePageDataByRoute($route, $slug)
	{
		$replace = null;

		if ($route == 'city-shop')
			$replace = $this->changeByCity($slug);
		elseif ($route == 'category')
			$replace = $this->changeByCategory($slug);
		elseif ($slug)
			abort(404);

		if ($replace)
			$this->replacePageData($replace);
	}

	private function changeByCategory($slug)
	{
		$this->category = Category::onlyModel(Product::class)
								->with('ancestors')
								->whereSlug($slug)
								->firstOrFail();

		$this->page->footer_description = $this->category->footer_description;

		return $this->category;
	}

	private function changeByCity($slug)
	{
		$city = Cities::find($slug);
		abort_if(!$city, 404);

		return $city['prepositional'];
	}

	private function shugarIds()
	{
		$category = Category::onlyModel(Product::class)
			->ordered()
			->whereSlug('shugars')
			->first();

		$firstIds = Product::publicCatalog($category)
							->isStock()
							->pluck('id');

		return $firstIds;
	}

}
