@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_code')
    @vite('resources/front/js/home.js')
@endsection


@section('content')



<div class="home-first-box">
    <div class="container">
        <div class="middle-row">
            <div class="h1">{{ $page['props']['home_title'] }}</div>
            <a href="{{ localRoute('front.pages', 'catalog') }}" class="btn">@lang('front.to_catalog')</a>
        </div>
    </div>
</div>

<div class="home-novelties-box">
    <div class="container grid-12">
        <div class="n-title">
            <div class="handwritten primary">New</div>
            <div class="h2">
                <span>@lang('front.home_page.popular_new')</span>
                <div class="ht-ints">
                    <span class="sw-current-int">1</span>
                    <span> / </span>
                    <span>{{ count($products) }}</span>
                </div>
            </div>
        </div>

        <div class="n-prod-name">
            <div class="prod-name"></div>
            <div class="prod-price secondary-alt price-el" data-cy="{{cy()}}"></div>
        </div>

        <div class="sw-arrow sw-prev sw-arrow-big">
            <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
        </div>

        <div class="n-slider">
            <div class="sw-arrow sw-prev">
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
            </div>
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($products as $prod)
                    <div class="swiper-slide">
                        <a href="{{ localRoute('front.products', $prod['slug']) }}" class="n-item">
                            <div class="n-image">
                                <img src="{{ $prod['preview'] }}" alt="" loading="lazy">
                            </div>
                            <div class="btn btn-secondary">@lang('front.more')</div>
                            <div class="n-info">
                                <div class="n-name">{{ $prod['title'] }}</div>
                                <div class="n-price">
                                    <span class="price-el" data-cy="{{cy()}}">@price($prod['price'])</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="sw-arrow sw-next">
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
            </div>
        </div>

        <div class="sw-arrow sw-next sw-arrow-big">
            <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
        </div>
    </div>
</div>

<div class="home-about-box">
    <div class="container">
        <div class="hab-wrap">
            <a href="{{ $props['instagram'] }}" target="_blank"  class="about-circle">
                <div class="logo-wrap">
                    @svg('images/icons/logo.svg')
                </div>
                <div class="ac-bottom">
                @svg('images/icons/instagram.svg')
                </div>
            </a>
            <div class="right-side">
                <div class="handwritten secondary">About</div>
                <div class="h2">@lang('front.home_page.about')</div>

                <a href="{{ $props['instagram'] }}" target="_blank"  class="about-circle">
                    <div class="logo-wrap">
                        @svg('images/icons/logo.svg')
                    </div>
                    <div class="ac-bottom">
                    @svg('images/icons/instagram.svg')
                    </div>
                </a>

                <div class="a-text">
                    {{ $page['props']['about_text'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="home-categories-box">
    <div class="container">
        <div class="hc-title">
            <div class="handwritten primary">Choose</div>
            <div class="h2">@lang('front.home_page.categories')</div>
        </div>
        <div class="cats-list grid-4">
            @foreach ($homeCategories as $cat)
                <a href="{{ localRoute('front.categories', $cat['slug']) }}" class="cat-item">
                    <div class="prod-image">
                        <img src="{{ $cat['preview'] }}" alt="{{ $cat['title'] }}" loading="lazy">
                    </div>
                    <div class="cat-name">{{ $cat['title'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>



@endsection
