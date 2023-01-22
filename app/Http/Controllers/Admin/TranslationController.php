<?php

namespace App\Http\Controllers\Admin;

use App\Models\Translation;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Str;

class TranslationController extends Controller
{

    public function index(Request $request)
    {
        $list = Translation::whereLang($this->getListLang())
                           ->orderByStr($request->get('sort'))
                           ->customPaginate($request->get('perPage', 50));

        return Inertia::render('Translations/Index', [
            'list' => $list,
        ]);
    }

    public function create()
    {
        $data = [
            'lang' => $this->getListLang() == 'ru' ? 'ru' : 'en',
            'key' => 'key_' . Str::random(5),
            'value' => 'value',
        ];

        Translation::create($data);

        return back();
    }

    public function update(Request $request, Translation $translation)
    {
        $data = $request->validate([
            'lang' => lang_rule(),
            'key' => 'required|string|max:255',
            'value' => 'string|nullable',
        ]);

        $translation->update($data);

        return back();
    }

    public function destroy(Translation $translation)
    {
        $translation->delete();

        return back();
    }
}
