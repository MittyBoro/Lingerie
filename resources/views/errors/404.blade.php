@extends('layouts.main')

@section('meta_title', __('front.error_page.not_found'))
@section('body_class', 'page-white')

@section('content')

<div class="page-box white-box error-box">
    <div class="container">
        <div class="white-item">
            @svg('/images/icons/404.svg')
            <div class="wh-subinfo">@lang('front.error_page.oops')</div>
            <a href="/catalog" class="btn">@lang('front.back_to_shopping')</a>
        </div>
    </div>
</div>

@endsection
