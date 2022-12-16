<?php

if ( !function_exists('lang_rule') ) {
    function lang_rule() {
        return ['required', 'string', \Illuminate\Validation\Rule::in(config('app.langs'))];
    }
}


if ( !function_exists('list_lang') ) {
    function list_lang() {
        return \Cookie::get('list_lang') ?? 'ru';
    }
}
