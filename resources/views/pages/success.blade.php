@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')
@section('body_class', 'page-white')

@section('content')

<div class="page-box white-box success-box">
    <div class="container">
        <div class="white-item">
            <div class="h1">
                <div><span class="secondary">@lang('front.success_page.thanks')</span> @lang('front.success_page.for_order')</div>
            </div>
            <div class="wh-subinfo">@lang('front.success_page.information')</div>
            <a href="#" class="btn">@lang('front.back_to_shopping')</a>
        </div>
    </div>
</div>

@endsection
