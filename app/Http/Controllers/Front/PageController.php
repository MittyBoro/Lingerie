<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $pageView = $request->get('page')->view;
        $viewName = view()->exists('pages.'.$pageView) ?
                                    'pages.'.$pageView : 'pages.page';

        return view($viewName);
    }
}
