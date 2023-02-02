<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        return $this->responseData();
    }


    public function store(Request $request, $id)
    {
        $product = Product::findForCart($id, locale());

        $validated = $request->validate([
            'options' => 'nullable|exists:product_options,id',
        ]);

        $optionsList = $product->getOptionsWords($validated['options'])->toArray();

        $cartId = $product->getCartId($validated['options']);

        $data = [
            'id' => $cartId,
            'name' => $product->title,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
                'options' => $optionsList,
            ],
        ];

        app('cart')->store($data, $product);

        return [
            'count' => app('cart')->count(),
            'mini' => app('cart')->getMini(),
        ];
    }

    public function update(Request $request, $cartId)
    {
        $data = $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        app('cart')->update($cartId, $data['quantity']);

        return $this->responseData();
    }

    public function destroy($cartId)
    {
        app('cart')->destroy($cartId);

        return $this->responseData();
    }

    public function clear()
    {
        app('cart')->clear();

        return true;
    }


    public function final()
    {
        return app('cart')->final();
    }

    private function responseData()
    {
        return [
            'data' => app('cart')->get(0),
        ];
    }


}
