<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{

	public function index(Request $request)
	{
		$tree = Category::getTree($request->model);

		return Inertia::render('Categories/Index', [
			'tree' => $tree,
		]);
	}

	public function create(Request $request, Category $category)
	{
		$list = Category::get4Admin($request->model);

		return Inertia::render('Categories/Form', [
			'list' => $list,
		]);
	}

	public function store(CategoryRequest $request, Category $category)
	{
		$validated = $request->validated();

		$validated['model_type'] = $request->get('model');

		$category = $category->create($validated);

		return redirect(route('admin.categories.edit', [
			'category' => $category->id,
			'type' => $request->get('type'),
		]));
	}

	public function edit(Request $request, Category $category)
	{
		$list = Category::get4Admin($request->model);

		return Inertia::render('Categories/Form', [
			'item' => $category,
			'list' => $list,
		]);
	}

	public function update(CategoryRequest $request, Category $category)
	{
		$data = $request->validated();

		try {
			$category->update($data);
		} catch (\Throwable $e) {
			return back()->withErrors(['parent_id' => 'Нарушена последовательность']);
		}

		return back();
	}

	public function sort(Request $request, Category $category)
	{
		$validated = $request->validate([
			'sorted' => 'required|array',
			'sorted.*.id'        => 'required|exists:categories,id',
			'sorted.*.position'  => 'required|integer',
			'sorted.*.parent_id' => 'nullable|exists:categories,id',
		]);

		$category->massUpdate($validated['sorted']);
		Category::fixTree();

		return back();
	}

	public function resort(Request $request, Category $category)
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

	public function destroy(Category $category)
	{
		if ($category->children->count()) {
			return back()->withErrors(['Невозможно удалить категорию с потомками']);
		}

		$category->delete();

		return back();
	}
}
