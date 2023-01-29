<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /*
        cart
            get
            add
            remove

        In Laravel, a common way to handle cart functionality is through the use of controllers. Here are some commonly used methods for a cart controller:

        index(): This method is used to display all items in the cart.
        store(): This method is used to add an item to the cart.
        update(): This method is used to update the quantity of an item in the cart.
        destroy(): This method is used to remove an item from the cart.
        clear(): This method is used to clear all items from the cart.
        count(): This method returns the total number of items in the cart
        total(): This method returns the total price of all items in the cart

        These are just examples and the implementation may vary depending on your project.
    */

    public function index(Request $request)
    {
        // $cart = app('CartService')->get();
        // return $cart;
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

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'string',
            'quantity' => 'integer|min:1',
        ]);

        app('CartService')->update($data['id'], $data['quantity']);

        return [
            'success' => true,
            ...$this->getCartData($request)
        ];
    }

    public function destroy(Request $request)
    {
        app('CartService')->destroy($request->get('id'));

        return [
            'success' => true,
            ...$this->getCartData($request)
        ];
    }


}