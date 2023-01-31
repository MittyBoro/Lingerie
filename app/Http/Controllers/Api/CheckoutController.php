<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function store(Request $request)
    {
        dd($request->all());


        return [
            'data' => app('CartService')->getReadable(),
        ];
    }

}
