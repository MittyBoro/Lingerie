<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Locale {

    const SESSION_KEY = 'locals';
    const LOCALES = ['en', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        $defaultLocale = config('app.locale');
        $locale = $this->getSelectedLocale($request, $defaultLocale);

        if ($locale && in_array($locale, self::LOCALES)) {
            Session::put(self::SESSION_KEY, $locale);
        }

        $this->setApp();

        return $next($request);
    }

    private function getSelectedLocale(Request $request, $defaultLocale)
    {
        if ($request->route()->named('front.locale')) {
            return $request->route()->parameters()['locale'];
        } elseif ($request->lang && Auth::user()?->is_admin) {
            return $request->lang;
        } elseif (!Session::has(self::SESSION_KEY)) {
            return $request->getPreferredLanguage(self::LOCALES);
        }

        return $defaultLocale;
    }

    private function setApp()
    {
        $locale = Session::get(self::SESSION_KEY);

        App::setLocale($locale);
        config( ['app.currency' => config('app.currencies.' . $locale)] );
    }
}
