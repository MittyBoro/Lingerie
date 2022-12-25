<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\ProductAttribute;
use Inertia\Inertia;

class ProductAttributeController extends Controller
{

    public function index()
    {
        $pages = ProductAttribute::paginated();

        return Inertia::render('ProductAttributes/Index', [
            'list' => $pages,
        ]);
    }

    public function create()
    {
        $data = [
            'type' => 'color',
            'value' => 'value',
        ];
        ProductAttribute::create($data);

        return back();
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'value' => 'required|string',
            'extra' => 'string|nullable',
        ]);
        $productAttribute->update($data);

        return back();
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();

        return back();
    }
}
