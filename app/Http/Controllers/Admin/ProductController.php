<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Inertia\Inertia;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::filter($request->all())
                            ->with('media')
                            // ->withPrice('*')
                            ->paginated();

        return Inertia::render('Products/Index', [
            'list' => $products,
            'categories' => ProductCategory::getList(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Products/Form', [
            'categories' => ProductCategory::getList(),
        ]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);
        $product->saveAfter($data);

        return redirect(route('admin.products.edit', $product->id));
    }

    public function edit(Product $product)
    {
        $product->setAppends(['gallery', 'size_table']);
        $product->load(['categories']);
        // $product->load(['categories', 'variations']);

        return Inertia::render('Products/Form', [
            'item' => $product,
            'categories' => ProductCategory::getList(),
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);
        $product->saveAfter($data);

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
        if ( $product->is_published ) {
            return back()->withErrors(['Запрещено удалять опубликованные элементы']);
        }

        $product->delete();

        return back();
    }
}
