<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\ProductOption;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::with('media')
                            ->filter($request->all(), $this->getListLang())
                            ->localized($this->getListLang(), true)
                            ->orderByStr($request->get('sort'))
                            ->customPaginate($request->get('perPage', 20));

        return Inertia::render('Products/Index', [
            'list' => $products,
            'categories' => ProductCategory::getList(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Form', [
            ...$this->editorData(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);
        $product->saveAfter($data);

        return redirect(route('admin.products.edit', $product->id));
    }

    public function show(Product $product)
    {
        return redirect()->route('front.product', ['slug' => $product->slug, 'lang' => $this->getListLang()]);
    }

    public function edit(Product $product)
    {
        $product->setAppends(['gallery', 'size_table']);
        $product->load(['categories', 'options', 'translations']);

        return Inertia::render('Products/Form', [
            'item' => $product,
            ...$this->editorData(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);
        $product->saveAfter($data);

        return back();
    }

	public function sort(Request $request)
	{
		$this->updateSort($request, new Product);

		return back();
	}

    public function destroy(Product $product)
    {
        if ( $product->is_published ) {
            return back()->withErrors(['Запрещено удалять опубликованные элементы']);
        }

        $product->delete();

        return back();
    }

    private function editorData() : array
    {
        return [
            'categories' => ProductCategory::getList(),
            'options' => ProductOption::get(),
        ];
    }
}
