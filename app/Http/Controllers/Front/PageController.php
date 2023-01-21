<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $viewName = view()->exists('pages.'.$request->page->view) ?
                                    'pages.'.$request->page->view : 'pages.page';

        return view($viewName);
    }
}
