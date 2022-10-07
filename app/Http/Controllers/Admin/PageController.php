<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PageRequest;
use Illuminate\Http\Request;

use App\Models\Page;

use Inertia\Inertia;

class PageController extends Controller
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

    public function store(PageRequest $request)
    {
        $data = $request->validated();
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

    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();
        $page->update($data);

        return back();
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return back();
    }
}
