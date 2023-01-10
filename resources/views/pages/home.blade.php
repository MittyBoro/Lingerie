@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')



<div class="home-first-box">
    <div class="container">
        <div class="middle-row">
            <div class="h1">Нижнее<i></i> белье<i></i> для девушек,<i></i> любящих своё<i></i> тело</div>
            <a href="/catalog" class="btn">в каталог</a>
        </div>
    </div>
</div>

<div class="home-novelties-box">
    <div class="container">
        <div class="n-title">
            <div class="handwritten primary">New</div>
            <div class="h2">
                <span>популярные новинки</span>
                <div class="ht-ints"><span><span class="sw-current-int">1</span> / <span>5</span></span></div>
            </div>
        </div>

        <div class="n-prod-name">
            <div class="prod-name">Длинный заголовок чудесного товара</div>
            <div class="prod-price secondary-alt"><span>4990</span> ₽</div>
        </div>

        <div class="sw-arrow sw-prev">
            <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
        </div>

        <div class="n-slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach (range(1, 7) as $i)
                    <div class="swiper-slide">
                        <div class="n-item">
                            <div class="n-image">
                                <img src="/storage/tmp/{{ rand(1,2) }}.png" alt="">
                            </div>
                            <a href="#" class="btn btn-secondary">подробнее</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="sw-arrow sw-next">
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
                <div class="h2">о<i></i> бренде</div>
                <div class="a-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lobortis sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate sit felis. Posuere nibh odio pellentesque porttitor convallis phasellus tristique. Tortor, diam duis pellent esque amet orci sed ornare consectetur nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="home-categories-box">
    <div class="container">
        <div class="handwritten">Choose</div>
        <div class="h2">категории товаров</div>
        <div class="cats-list">
            <div class="cat-item">
                <div class="cat-img"><img src="/storage/tmp/cat-1.png" alt=""></div>
                <div class="cat-name">Нижнее белье</div>
            </div>
            <div class="cat-item">
                <div class="cat-img"><img src="/storage/tmp/cat-2.png" alt=""></div>
                <div class="cat-name">Купальники</div>
            </div>
            <div class="cat-item">
                <div class="cat-img"><img src="/storage/tmp/cat-3.png" alt=""></div>
                <div class="cat-name">одежда для дома</div>
            </div>
            <div class="cat-item">
                <div class="cat-img"><img src="/storage/tmp/cat-4.png" alt=""></div>
                <div class="cat-name">комплекты</div>
            </div>
        </div>
    </div>
</div>



@endsection
