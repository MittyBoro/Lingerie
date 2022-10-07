@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="contract-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>{{ $page['title'] }}</span>
        </div>

        <div class="contract-top-content">

            <div class="content-side">
                <h1 class="h2 h2-title">{{ $page['title'] }}</h1>

                <div class="contract-text formatted-text">
                    {!! $page['description'] !!}
                </div>
            </div>

            <div class="sidebar">

                <div class="c-photo">
                    <img src="{{ $page->props['photo'] }}" alt="">
                </div>

                <div class="btn btn-mini cats-toggle">Категории</div>

                <div class="line-title ttu">Категории товаров</div>

                @include('elements.catalog_menu', ['categories' => $left_menu])
            </div>
        </div>

        <div class="order-form go-contract">
            <h2 class="h2 h2-title">Получить персональное предложение</h2>
            <form @submit.prevent="submit" class="form-row col-lg-9 mr-auto">
                <input type="hidden" :value="form.form = 'contract'">
                <div class="f-wrap">
                    <input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
                    <div class="f-placeholder">Ваше имя</div>
                    @svg('images/svg/user.svg')
                </div>
                <div class="space"></div>
                <div class="f-wrap">
                    <input placeholder="text" type="text" autocomplete="tel" v-model="form.phone" required>
                    <div class="f-placeholder">Ваш телефон</div>
                    @svg('images/svg/phone.svg')
                </div>
                <div class="space"></div>
                <button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
                    <span :class="{ hidden: success }">Оставить заявку</span>
                    <span :class="{ hidden: !success }">Заявка принята</span>
                </button>
            </form>
        </div>

        <div class="content-side">
            <div class="contract-text formatted-text">
                {!! $page->props['description_after_form'] !!}
            </div>
        </div>


        <div class="contract-svg">
            <div class="c-item">
                @svg('images/svg/c-1.svg')
                <p>Ваша<br>заявка</p>
            </div>
            <div class="arrow">@svg('images/svg/arrow.svg')</div>
            <div class="c-item">
                @svg('images/svg/c-2.svg')
                <p>Наша<br>консультация</p>
            </div>
            <div class="arrow">@svg('images/svg/arrow.svg')</div>
            <div class="c-item">
                @svg('images/svg/c-3.svg')
                <p>Разработка<br>дизайна</p>
            </div>
            <div class="arrow">@svg('images/svg/arrow.svg')</div>
            <div class="c-item">
                @svg('images/svg/c-4.svg')
                <p>Производство<br>продукции</p>
            </div>
            <div class="arrow">@svg('images/svg/arrow.svg')</div>
            <div class="c-item">
                @svg('images/svg/c-5.svg')
                <p>Доставка<br>вам</p>
            </div>
            <div class="arrow">@svg('images/svg/arrow.svg')</div>
            <div class="c-item">
                @svg('images/svg/c-6.svg')
                <p>Ваш<br>доход</p>
            </div>
        </div>


        <div class="contract-gallery">
            <h2 class="h2 h2-title">Контрактное производство от ALeVi</h2>
            <div class="gallery-thumbs">
                <div class="swiper-button swiper-button-prev">
                    @svg('images/svg/arrow.svg')
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper lightgallery">
                        @foreach ($page->props['photos'] ?? [] as $image)
                            <a href="{{ $image }}" class="swiper-slide">
                                <div class="img-wrap">
                                    <img src="{{ $image }}" alt="">
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button swiper-button-next">
                    @svg('images/svg/arrow.svg')
                </div>
            </div>
        </div>
        <div class="contract-gallery contract-video">
            <div class="video-slider">
                <div class="swiper-button swiper-button-prev">
                    @svg('images/svg/arrow.svg')
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($page->props['videos'] ?? [] as $video)
                            <div class="swiper-slide video-slide">
                                <video style="max-width: 100%;" controls="controls" width="700" height="450">
                                    <source src="{{ $video }}">
                                </video>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button swiper-button-next">
                    @svg('images/svg/arrow.svg')
                </div>
            </div>
        </div>


        <div class="cities-wrap">
            <h2 class="h2 h2-title">Наши представительства в других городах</h2>
            <div class="cities-list">
                @foreach ($cities as $city)
                    <a href="/city-shop/{{ $city['slug'] }}" class="city-item">{{ $city['name'] }}</a>
                @endforeach
            </div>
            <div class="show-more btn btn-mini">
                <span>смотреть все</span>
                <span>скрыть</span>
            </div>
        </div>



    </div>
</div>

@endsection

@section('body_end')

    <script src="{{ mix('js/gallery.js', 'assets') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.show-more').addEventListener('click', function() {
                let parent = this.closest('.cities-wrap');
                parent.classList.toggle('active');
            });
        });
    </script>

@endsection
