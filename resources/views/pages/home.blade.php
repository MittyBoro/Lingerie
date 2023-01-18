@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_end')
    @vite('resources/front/js/home.js')
@endsection


@section('content')



<div class="home-first-box">
    <div class="container">
        <div class="middle-row">
            <div class="h1">Нижнее<i></i> белье<i></i> для девушек,<i></i> любящих своё<i></i> тело</div>
            <a href="/catalog" class="btn">@lang('front.to_catalog')</a>
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
                    <span>5</span>
                </div>
            </div>
        </div>

        <div class="n-prod-name">
            <div class="prod-name"></div>
            <div class="prod-price secondary-alt"><span class="prod-price-value"></span> ₽</div>
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
                    @foreach (range(1, 7) as $i)
                    <div class="swiper-slide">
                        <a href="#" class="n-item">
                            <div class="n-image">
                                <img data-src="/storage/tmp/{{ rand(1,2) }}.png" alt="" class="swiper-lazy">
                            </div>
                            <div class="btn btn-secondary">@lang('front.more')</div>
                            <div class="n-info">
                                <div class="n-name">Длинный заголовок чудесного товара #{{ $i }}</div>
                                <div class="n-price"><span class="n-price-value">{{ $i }}000</span> ₽</div>
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
            <a href="#" class="about-circle">
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

                <a href="#" class="about-circle">
                    <div class="logo-wrap">
                        @svg('images/icons/logo.svg')
                    </div>
                    <div class="ac-bottom">
                    @svg('images/icons/instagram.svg')
                    </div>
                </a>

                <div class="a-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lobortis sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate sit felis. Posuere nibh odio pellentesque porttitor convallis phasellus tristique. Tortor, diam duis pellent esque amet orci sed ornare consectetur nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate.
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
            <a class="cat-item">
                <div class="prod-image"><img src="/storage/tmp/cat-1.png" alt=""></div>
                <div class="cat-name">Нижнее белье</div>
            </a>
            <a class="cat-item">
                <div class="prod-image"><img src="/storage/tmp/cat-2.png" alt=""></div>
                <div class="cat-name">Купальники</div>
            </a>
            <a class="cat-item">
                <div class="prod-image"><img src="/storage/tmp/cat-3.png" alt=""></div>
                <div class="cat-name">одежда для дома</div>
            </a>
            <a class="cat-item">
                <div class="prod-image"><img src="/storage/tmp/cat-4.png" alt=""></div>
                <div class="cat-name">комплекты</div>
            </a>
        </div>
    </div>
</div>



@endsection
