<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $page = $request->page;



        return view('pages.catalog');
    }

    public function categories(Request $request)
    {
        $page = $request->page;



        return view('pages.catalog');
    }
}
