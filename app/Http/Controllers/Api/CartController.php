<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        return $this->responseData();
    }


    public function store(Request $request)
    {
        $product = Product::findForCart($request->id, locale());

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


    public function update(Request $request)
    {
        $data = $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        app('cart')->update($request->cart_id, $data['quantity']);

        return $this->responseData();
    }


    public function destroy(Request $request)
    {
        app('cart')->destroy($request->cart_id);

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
