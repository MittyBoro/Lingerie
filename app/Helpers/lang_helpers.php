<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

if ( !function_exists('lang_rule') ) {
    function lang_rule() {
        return ['required', 'string', \Illuminate\Validation\Rule::in(config('app.langs'))];
    }
}


if ( !function_exists('admin_lang') ) {
    function admin_lang() {
        return Cookie::get('admin_lang') ?? 'ru';
    }
}


if ( !function_exists('cy') ) {
    function cy() {
        return config('app.currency');
    }
}

if ( !function_exists('cySymb') ) {
    function cySymb($cy) {
        if ($cy == 'usd')
            return '$';
        if ($cy == 'rub')
            return '₽';

        return $cy;
    }
}

if (!function_exists('replace_lang_in_url')) {
    // тест сказал так быстрее
    function replace_lang_in_url($url, $lang) {
        return preg_replace('#^(.+://[^/]+)/[^/]+#', '$1/'.$lang, $url);
    }
}

if (!function_exists('alt_langs')) {
    function alt_langs($lang) {
        $langs = config('app.langs');
        return array_filter($langs, fn($val)=> $val !== $lang);
    }
}

if (!function_exists('loc_REG')) {
    function loc_REG($lang = null) {
        if (!$lang)
            $lang = lang();

        if ($lang == 'ru') {
            return 'ru_RU';
        }
        else {
            return 'en_US';
        }
    }
}

if (!function_exists('lang')) {
    function lang() {
        return App::getLocale();
    }
}

if (!function_exists('locale')) {
    function locale() {
        return lang();
    }
}

if (!function_exists('localRoute')) {
    function localRoute(...$args) {

        $args[1] = [
            ...(array) ($args[1] ?? null),
            'lang' => lang(),
        ];

        return route(...$args);
    }
}

