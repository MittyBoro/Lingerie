<?php

namespace App\Http\Middleware;

use App\Models\Page;
use Closure;
use Illuminate\Http\Request;

class OnlyPage {

    public function handle(Request $request, Closure $next)
    {
        $slug = explode('/', $request->path())[0] ?: 'home';

        $page = Page::findBySlug($slug);

        $request->merge(['page' => $page,]);

        return $next($request);
    }

}
