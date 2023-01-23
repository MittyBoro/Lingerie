<?php

namespace App\Http\Middleware;

use App\Models\Page;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class OnlyPage {

    public function handle(Request $request, Closure $next)
    {
        $slug = explode('/', $request->path())[0] ?: 'home';
        $lang = App::getLocale();

        $page = Page::findForFront($slug, $lang);

        $request->merge(['page' => $page,]);

        View::share('page', $page);

        return $next($request);
    }

}