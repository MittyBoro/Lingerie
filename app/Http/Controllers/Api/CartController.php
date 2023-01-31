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
        $product = Product::findForCart($id, $this->getLang());

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

        app('CartService')->store($data, $product);

        return [
            'count' => app('CartService')->count(),
            'mini' => app('CartService')->getMini(),
        ];
    }

    public function update(Request $request, $cartId)
    {
        $data = $request->validate([
            'quantity' => 'integer|min:1',
        ]);

        app('CartService')->update($cartId, $data['quantity']);

        return $this->responseData();
    }

    public function destroy($cartId)
    {
        app('CartService')->destroy($cartId);

        return $this->responseData();
    }

    public function clear()
    {
        app('CartService')->clear();

        return true;
    }


    public function final()
    {
        return app('CartService')->final();
    }

    private function responseData()
    {
        return [
            'data' => app('CartService')->get(0),
        ];
    }


}
