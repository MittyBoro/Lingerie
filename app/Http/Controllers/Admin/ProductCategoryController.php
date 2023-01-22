<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\ProductCategory;
use App\Http\Requests\Admin\ProductCategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{

    public function index(Request $request)
    {
        $tree = ProductCategory::getTree($request->model);

        return Inertia::render('ProductCategories/Index', [
            'tree' => $tree,
        ]);
    }

    public function create()
    {
        $list = ProductCategory::getList();

        return Inertia::render('ProductCategories/Form', [
            'list' => $list,
        ]);
    }

    public function store(ProductCategoryRequest $request)
    {
        $data = $request->validated();

        $productCategory = ProductCategory::create($data);
        $productCategory->saveAfter($data);

        return redirect(route('admin.product_categories.edit', [
            'product_category' => $productCategory->id,
        ]));
    }

    public function show(ProductCategory $productCategory)
    {
        dd($productCategory);
        return redirect('/');
    }

    public function edit(ProductCategory $productCategory)
    {
        $list = ProductCategory::whereNot('id', $productCategory->id)->getList();

        return Inertia::render('ProductCategories/Form', [
            'item' => $productCategory,
            'list' => $list,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $data = $request->validated();

        try {
            $productCategory->update($data);
            $productCategory->saveAfter($data);
        } catch (\Throwable $e) {
            return back()->withErrors(['parent_id' => 'Нарушена последовательность']);
        }

        return back();
    }

    public function sort(Request $request)
    {
        $this->updateSort(
                    $request,
                    new ProductCategory,
                    ['sorted.*.parent_id' => 'nullable|exists:product_categories,id']
               );

        ProductCategory::fixTree();

        return back();
    }


    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->children->count()) {
            return back()->withErrors(['Невозможно удалить категорию с потомками']);
        }

        $productCategory->delete();

        return back();
    }
}
