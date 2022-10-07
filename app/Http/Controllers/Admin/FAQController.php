<?php

namespace App\Http\Controllers\Admin;

use App\Models\FAQ;
use Illuminate\Http\Request;

use Inertia\Inertia;

class FAQController extends Controller
{

    public function index()
    {
        $faqs = FAQ::paginated();

        return Inertia::render('FAQs/Index', [
            'list' => $faqs,
        ]);
    }

    public function create()
    {
        return Inertia::render('FAQs/Form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $created = FAQ::create($data);

        return redirect(route('admin.FAQs.edit', $created->id));
    }

    public function edit(FAQ $faq)
    {
        return Inertia::render('FAQs/Form', [
            'item' => $faq,
            'props' => $faq->properties()->get4Admin(),
        ]);
    }

    public function update(Request $request, FAQ $faq)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $faq->update($data);

        return back();
    }

    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return back();
    }
}
