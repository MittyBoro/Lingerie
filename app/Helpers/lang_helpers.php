<?php

use Illuminate\Support\Facades\App;

if ( !function_exists('lang_rule') ) {
    function lang_rule() {
        return ['required', 'string', \Illuminate\Validation\Rule::in(config('app.langs'))];
    }
}


if ( !function_exists('admin_lang') ) {
    function admin_lang() {
        return \Cookie::get('admin_lang') ?? 'ru';
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

if (!function_exists('locale')) {
    function locale() {
        return \App::getLocale();
    }
}

if (!function_exists('lang')) {
    function lang() {
        return \App::getLocale();
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

