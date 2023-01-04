<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PropRequest;
use App\Models\Admin\Page;
use App\Models\Admin\Prop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PropController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->edit) {
            return Inertia::render('Props/Index', [
                'list' => Prop::whereNull('model_id')->get4Admin(),
                'tabs' => Prop::tabs(),
            ]);
        }
        else {
            $prop = Prop::with(['media', 'model']);

            if (!$request->orderby)
                $prop = $prop
                            ->orderBy('model_type')
                            ->orderBy('model_id')
                            ->orderBy('tab')
                            ->orderBy('position');

            return Inertia::render('Props/Edit', [
                'list' => $prop->paginated('model_name'),
                'types' => Prop::TYPES,
            ]);
        }

    }

    public function create()
    {
        return Inertia::render('Props/Form', [
            ...$this->editorData()
        ]);
    }

    public function store(PropRequest $request, Prop $prop)
    {
        $validated = $request->validated();

        $created = $prop->create($validated);

        return redirect(route('admin.props.edit', [
            'prop' => $created->id,
        ]));
    }

    public function edit(Prop $prop)
    {
        $prop->load(['model']);

        return Inertia::render('Props/Form', [
            'item' => $prop,

            ...$this->editorData()
        ]);
    }

    public function update(PropRequest $request, Prop $prop)
    {
        $prop->updateItem($request->validated());
        return back();
    }

    public function sort(Request $request, Prop $prop)
    {
        $validated = $this->validateSort($request, 'props');
        $prop->massUpdate($validated);

        return back();
    }


    public function destroy(Prop $prop)
    {
        $prop->delete();
        return redirect()->route('admin.props.index', ['edit' => true]);
    }

    private function editorData() : array
    {
        return [
            'pages' => Page::get(['id', 'title', 'slug']),
            'types' => Prop::TYPES,
            'tabs' => Prop::tabs(),
        ];
    }
}
