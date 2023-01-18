<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale {

    const SESSION_KEY = 'locale';
    const LOCALES = ['en', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        if (!Session::has(self::SESSION_KEY)) {
            $locale = $request->getPreferredLanguage(self::LOCALES);
            Session::put(self::SESSION_KEY, $locale);
        }

        if ($request->route()->named('front.locale')) {
            $locale = $request->route()->parameters()['locale'];
            if ( in_array($locale, self::LOCALES) )
                Session::put(self::SESSION_KEY, $locale);
        }

        App::setLocale(Session::get(self::SESSION_KEY));

        return $next($request);
    }
}
