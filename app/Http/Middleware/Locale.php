<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale {

    const SESSION_KEY = 'locals';
    const LOCALES = ['en', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        $this->setSessionLocale($request);
        $this->setAppLocale();

        return $next($request);
    }

    private function setSessionLocale($request)
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
    }
    private function setAppLocale()
    {
        $locale = Session::get(self::SESSION_KEY);

        App::setLocale($locale);
        config( ['app.currency' => config('app.currencies.' . $locale)] );
    }
}
