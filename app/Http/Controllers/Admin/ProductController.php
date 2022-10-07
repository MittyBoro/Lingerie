<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductCategory;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::filter($request->all())
                            ->with('media')
                            ->withPrice('*')
                            ->paginated();

        return Inertia::render('Products/Index', [
            'list' => $products,
            'categories' => ProductCategory::get4Admin(Product::class),
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

        $data['user_id'] = $request->user()->id;

        $product = Product::create($data);
        $product->saveRelations($data);

        return redirect(route('admin.products.edit', $product->id));
    }

    public function edit(Product $product)
    {
        $product->editing = true;

        $product->setAppends(['gallery']);
        $product->load(['categories', 'variations']);

        return Inertia::render('Products/Form', [
            'item' => $product,

            ...$this->editorData(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);
        $product->saveRelations($data);

        return back();
    }

    public function sort(Request $request, Product $product)
    {
        $validated = $this->validateSort($request, 'products');

        $product->massUpdate($validated);

        return back();
    }

    public function destroy(Product $product)
    {
        if ( $product->is_published )
        {
            return back()->withErrors(['Запрещено удалять опубликованные товары']);
        }

        $product->delete();

        return back();
    }

    private function editorData() : array
    {
        return [
            'categories' => ProductCategory::get4Admin(Product::class),
            'characteristics_list' => Product::characteristicsList(),
        ];
    }
}
