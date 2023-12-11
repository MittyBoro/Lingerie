<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductOption;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductOptionController extends Controller
{

    public function index(Request $request)
    {
        $pages = ProductOption::orderByStr($request->get('sort'))
                                 ->customPaginate($request->get('perPage', 40));

        return Inertia::render('ProductOptions/Index', [
            'list' => $pages,
        ]);
    }

    public function create()
    {
        $data = [
            'type' => 'color',
            'value' => 'value',
        ];
        ProductOption::create($data);

        return back();
    }

    public function update(Request $request, ProductOption $productOption)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'value' => 'required|string',
            'extra' => 'string|nullable',
        ]);
        $productOption->update($data);

        return back();
    }

	public function sort(Request $request)
	{
		$this->updateSort($request, new ProductOption);

		return back();
	}

    public function destroy(ProductOption $productOption)
    {
        $productOption->delete();

        return back();
    }
}
