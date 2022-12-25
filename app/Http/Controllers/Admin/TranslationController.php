<?php

namespace App\Http\Controllers\Admin;

use App\Models\Translation;
use Illuminate\Http\Request;

use Inertia\Inertia;

class TranslationController extends Controller
{

    public function index()
    {
        $list = Translation::byLang($this->getListLang())->paginated();

        return Inertia::render('Translations/Index', [
            'list' => $list,
        ]);
    }

    public function create()
    {
        return Inertia::render('Translations/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lang' => lang_rule(),
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $created = Translation::create($data);

        return redirect(route('admin.faqs.edit', $created->id));
    }

    public function edit(Translation $faq)
    {
        return Inertia::render('Translations/Form', [
            'item' => $faq,
        ]);
    }

    public function update(Request $request, Translation $faq)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lang' => lang_rule(),
        ]);

        $faq->update($data);

        return back();
    }

    public function destroy(Translation $faq)
    {
        $faq->delete();

        return back();
    }
}
