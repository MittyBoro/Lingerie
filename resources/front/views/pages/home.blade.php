@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')



<div class="home-first-box">
    <div class="container">
        <div class="middle-row">
            <div class="h1">Нижнее белье для девушек, любящих своё тело</div>
            <a href="/catalog" class="btn">в каталог</a>
        </div>
    </div>
</div>

<div class="home-novelties-box">
    <div class="container">
        <div class="n-title">
            <div class="handwritten">New</div>
            <div class="h-title-row">
                <div class="h2">популярные новинки</div>
                <div class="ht-ints"><span>4</span> / <span>5</span></div>
            </div>
        </div>
        <div class="noventies-list">
            <div class="nov-item">
                <div class="nov-image">
                    <img src="" alt="">
                    <a href="#" class="nov-btn btn-2">подробнее</a>
                </div>
                <div class="nov-info">
                    <div class="nov-name">Длинный заголовок чудесного товара</div>
                    <div class="nov-price">4990 ₽</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="home-about-box">
    <div class="container">
        <a href="#" class="about-circle">
            @svg('images/icons/logo.svg')
            <div class="ac-bottom">
             @svg('images/icons/instagram.svg')
            </div>
        </a>
        <div class="right-side">
            <div class="handwritten">About</div>
            <div class="h2">о бренде</div>
            <div class="a-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lobortis sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate sit felis. Posuere nibh odio pellentesque porttitor convallis phasellus tristique. Tortor, diam duis pellent esque amet orci sed ornare consectetur nibh. Lorem ipsum dolor sit amet, consectetur adipiscing elit sit orci viverra nunc, vivamus vitae. In tincidunt morbi vulputate.
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
