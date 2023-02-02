<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PageRequest;
use App\Models\Admin\Page;
use Illuminate\Http\Request;

use Inertia\Inertia;


class PageController extends Controller
{

    public function index(Request $request)
    {
        $pages = Page::whereLang($this->getListLang())
                     ->orderByStr($request->get('sort'))
                     ->customPaginate($request->get('perPage', 20));

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

    public function show(Page $page)
    {
        return redirect()->route('front.page', ['path' => $page->slug, 'lang' => $page->lang]);
    }

    public function edit(Page $page)
    {
        $page->load(['props'])->setAppends(['alt_langs']);

        return Inertia::render('Pages/Form', [
            'item' => $page,
        ]);
    }

    public function update(PageRequest $request, Page $page)
    {
        $data = $request->validated();
        $page->update($data);
        $page->saveAfter($data);

        return back();
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return back();
    }
}
