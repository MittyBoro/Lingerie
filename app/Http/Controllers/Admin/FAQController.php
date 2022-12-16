<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;

use Inertia\Inertia;

class FAQController extends Controller
{

    public function index()
    {
        $list = FAQ::byLang($this->getListLang())->paginated();

        return Inertia::render('FAQs/Index', [
            'list' => $list,
        ]);
    }

    public function create()
    {
        return Inertia::render('FAQs/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lang' => lang_rule(),
        ]);

        $created = FAQ::create($data);

        return redirect(route('admin.faqs.edit', $created->id));
    }

    public function edit(FAQ $faq)
    {
        return Inertia::render('FAQs/Form', [
            'item' => $faq,
        ]);
    }

    public function update(Request $request, FAQ $faq)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'lang' => lang_rule(),
        ]);

        $faq->update($data);

        return back();
    }

	public function sort(Request $request, FAQ $item)
	{
		$validated = $this->validateSort($request, 'faqs');

		$item->massUpdate($validated);

		return back();
	}

    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return back();
    }
}
