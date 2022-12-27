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
        $productCategory->saveRelations($data);

        return redirect(route('admin.product_categories.edit', [
            'product_category' => $productCategory->id,
        ]));
    }

    public function edit(ProductCategory $productCategory)
    {
        $list = ProductCategory::getList();

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
            $productCategory->saveRelations($data);
        } catch (\Throwable $e) {
            return back()->withErrors(['parent_id' => 'Нарушена последовательность']);
        }

        return back();
    }

    public function sort(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id'        => 'required|exists:categories,id',
            'sorted.*.position'  => 'required|integer',
            'sorted.*.parent_id' => 'nullable|exists:categories,id',
        ]);

        $productCategory->massUpdate($validated['sorted']);
        ProductCategory::fixTree();

        return back();
    }

    public function resort(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id' => 'exists:categories,id',
            'sorted.*.parent_id' => 'nullable|present|exists:categories,id',
        ]);

        $isUpd = $productCategory->updateTree($validated['sorted']);
        if ($isUpd)
            return back();
        else
            return back()->withErrors(['Ошибка обновления']);
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
