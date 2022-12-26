<?php

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
