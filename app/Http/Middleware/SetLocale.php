<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale {

    const LOCALES = ['en', 'ru'];

    public function handle(Request $request, Closure $next)
    {
        if ($request->setlang && in_array($request->setlang, self::LOCALES)) {
            $url = url()->previous();
            $newUrl = replace_lang_in_url($url, $request->setlang);
            return redirect($newUrl);
        }

        $locale = $request->route('lang');

        if ($locale === null) {
            $locale = $request->getPreferredLanguage(self::LOCALES);
            $routeName = $request->route()->getName();
            $routeParams = $request->route()->parameters();
            $routeParams['lang'] = $locale;

            return redirect()->route($routeName, $routeParams);
        }

        elseif (!in_array($locale, self::LOCALES)) {
            abort(404);
        }

        App::setLocale($locale);
        config( ['app.currency' => config('app.currencies.' . $locale)] );

        return $next($request);
    }

}
