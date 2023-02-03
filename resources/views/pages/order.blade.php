@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')
@section('body_class', 'page-white')

@section('content')

<div class="page-box white-box order-box">
    <div class="container">



        <div class="white-item">

            @if ($order['status'] == $order::STATUS_SUCCESS)
                <div class="h1">
                    <div><span class="secondary">@lang('front.order_page.thanks')</span> @lang('front.order_page.for_order')</div>
                </div>
                <div class="wh-subinfo">
                    @lang('front.order_page.information')
                </div>
            @elseif ($order['status'] == $order::STATUS_REFUNDED)
                <div class="h1 primary-alt">@lang('front.order_page.refunded')</div>
                <div class="wh-subinfo"></div>
            @elseif ($order['status'] == $order::STATUS_PENDING)
                <div class="h1 gray">@lang('front.order_page.pending')</div>
                <div class="wh-subinfo">
                    @isset($order['redirect_url'])
                        @lang('front.order_page.continue_link', ['link' => $order['redirect_url']])
                    @endisset
                </div>
            @else
                <div class="h1 red">@lang('front.order_page.canceled')</div>
                <div class="wh-subinfo"></div>
            @endif

            <a href="{{ localRoute('front.pages', 'catalog') }}" class="btn">@lang('front.back_to_shopping')</a>
        </div>
    </div>
</div>

@endsection
