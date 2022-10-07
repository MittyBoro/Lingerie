<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductCategoryController extends Controller
{

    public function index(Request $request)
    {
        $tree = ProductCategory::getTree($request->model);

        return Inertia::render('Categories/Index', [
            'tree' => $tree,
        ]);
    }

    public function create(Request $request, ProductCategory $category)
    {
        $list = ProductCategory::get4Admin($request->model);

        return Inertia::render('Categories/Form', [
            'list' => $list,
        ]);
    }

    public function store(CategoryRequest $request, ProductCategory $category)
    {
        $validated = $request->validated();

        $category = $category->create($validated);

        return redirect(route('admin.categories.edit', [
            'category' => $category->id,
            'type' => $request->get('type'),
        ]));
    }

    public function edit(Request $request, ProductCategory $category)
    {
        $list = ProductCategory::get4Admin($request->model);

        return Inertia::render('Categories/Form', [
            'item' => $category,
            'list' => $list,
        ]);
    }

    public function update(CategoryRequest $request, ProductCategory $category)
    {
        $data = $request->validated();

        try {
            $category->update($data);
        } catch (\Throwable $e) {
            return back()->withErrors(['parent_id' => 'Нарушена последовательность']);
        }

        return back();
    }

    public function sort(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id'        => 'required|exists:categories,id',
            'sorted.*.position'  => 'required|integer',
            'sorted.*.parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->massUpdate($validated['sorted']);
        ProductCategory::fixTree();

        return back();
    }

    public function resort(Request $request, ProductCategory $category)
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id' => 'exists:categories,id',
            'sorted.*.parent_id' => 'nullable|present|exists:categories,id',
        ]);

        $isUpd = $category->updateTree($validated['sorted']);
        if ($isUpd)
            return back();
        else
            return back()->withErrors(['Ошибка обновления']);
    }

    public function destroy(ProductCategory $category)
    {
        if ($category->children->count()) {
            return back()->withErrors(['Невозможно удалить категорию с потомками']);
        }

        $category->delete();

        return back();
    }
}
