@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_end')
    @vite('resources/front/js/product.js')
@endsection

@section('content')

<div class="product-box">
    <div class="container">
        <div class="prod-grid grid-12">
            <div class="prod-main-col prod-main-col-mini">
                <div class="breadcrumbs">
                    <a href="/">@lang('front.home')</a>
                    @foreach ($product['bread_cats'] as $cat)
                    <span class="delimeter">/</span>
                    <a href="{{ route('front.categories', $cat['slug']) }}">{{ $cat['title'] }}</a>
                    @endforeach
                </div>
                <div class="prod-title">{{ $product['title'] }}</div>
            </div>

            <div class="prod-main-col left-col">
                <div class="pmc-top">
                    <div class="breadcrumbs">
                        <a href="#">Главная</a>
                        @foreach ($product['bread_cats'] as $cat)
                        <span class="delimeter">/</span>
                        <a href="{{ route('front.categories', $cat['slug']) }}">{{ $cat['title'] }}</a>
                        @endforeach
                    </div>
                    <div class="prod-title"><h1>{{ $product['title'] }}</h1></div>
                </div>

                @if ($product['colors'])
                <div class="prod-attr-wrap">
                    <div class="pm-title">@lang('front.product_page.size')</div>
                    <div class="pm-list pm-size">
                        @foreach ($product['sizes'] as $size)
                        <label class="form-radio pm-item">
                            <input type="radio" name="size" value="{{ $size['value'] }}">
                            <div class="fr-item">
                                <span>{{ $size['value'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if ($product['colors'])
                <div class="prod-attr-wrap">
                    <div class="pm-title">@lang('front.product_page.color')</div>
                    <div class="pm-list pm-color">
                        @foreach ($product['colors'] as $color)
                        <label class="form-radio pm-item">
                            <input type="radio" name="color" value="{{ $color['value'] }}">
                            <div class="fr-item">
                                <span style="{{ $color['extra'] }}"></span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="prod-price">
                    @if ($cy == 'rub')
                        <span>@price($product['price'])</span> {{ $cySymb }}
                    @else
                        {{ $cySymb }}<span>@price($product['price'])</span>
                    @endif
                </div>
                <div class="btn">@lang('front.add_to_cart')</div>
            </div>

            <div class="gallery-col right-col">
                <div class="full-row">
                    <div class="swiper">
                        <div class="swiper-wrapper lightgallery">
                            @foreach ($product['gallery'] ?? [] as $img)
                            <a class="swiper-slide" href="{{ $img['big'] }}">
                                <div class="prod-image zoom-image" style="background-image: url('{{ $img['big'] }}')"><img src="{{ $img['medium'] }}" alt=""></div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="sw-arrow sw-prev">
                        <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                    </div>
                    <div class="sw-arrow sw-next">
                        <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                    </div>
                </div>
                <div class="thumbs-row">
                    <div class="swiper-scrollbar"></div>
                    <div class="swiper-container">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ($product['gallery'] ?? [] as $img)
                                    <div class="swiper-slide">
                                        <div class="prod-image"><img src="{{ $img['thumb'] }}" alt=""></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-info-col left-col">
                @foreach ($product['details'] as $k => $text)
                <div class="bi-item active" toggling>
                    <div class="b-title" toggle-click>
                        <span>@lang('front.product_page.'. $k)</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="bi-text text-el" toggle-el>{!! nl2br($text) !!}</div>
                </div>
                @endforeach
            </div>
            @if ($product['sizes_table'])
            <div class="bottom-table-col right-col active" toggling>
                <div class="b-title" toggle-click>
                    <span>@lang('front.product_page.sizes_table')</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                </div>
                <div class="table-el" toggle-el>
                    <img src="{{ $product['sizes_table'] }}" alt="">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if (count($product['similars']))
<div class="catalog-box product-catalog-box">
    <div class="container">
        <div class="handwritten secondary">Look</div>
        <div class="h2">@lang('front.product_page.may_like')</div>
        <div class="catalog-list grid-4">
            @foreach ($product['similars'] as $prod)
                @include('elements.catalog_item')
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
