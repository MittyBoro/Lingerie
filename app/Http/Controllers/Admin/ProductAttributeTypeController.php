<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Page;

use Inertia\Inertia;

class ProductAttributeTypeController extends Controller
{

	public function index()
	{
		$pages = Page::paginated();

		return Inertia::render('Pages/Index', [
			'list' => $pages,
		]);
	}

	public function create()
	{
		return Inertia::render('Pages/Form');
	}

	public function store(Request $request)
	{
        $data = $request->validate([
            'name' => 'required|string',
        ]);

		$created = Page::create($data);

		return redirect(route('admin.pages.edit', $created->id));
	}

	public function edit(Page $page)
	{
		return Inertia::render('Pages/Form', [
			'item' => $page,
			'props' => $page->properties()->get4Admin(),
		]);
	}

	public function update(Request $request, Page $page)
	{
        $data = $request->validate([
            'name' => 'required|string',
        ]);

		$page->update($data);

		return back();
	}

	public function destroy(Page $page)
	{
		$page->delete();

		return back();
	}
}
