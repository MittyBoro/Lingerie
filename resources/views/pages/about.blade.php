@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="about-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>{{ $page['title'] }}</span>
        </div>

        <h1 class="h2 h2-title">{{ $page['title'] }}</h1>

        <div class="about-text">
            {!! str_ireplace('[PHOTO_ALEVI]', "<img src='{$page->props['a_photo_alevi']}' >", $page['description']) !!}
        </div>

        <div class="h2 h2-title">Наши сертификаты</div>
        <div class="about-gallery">
            <div class="gallery-thumbs">
                <div class="swiper-button swiper-button-prev">
                    @svg('images/svg/arrow.svg')
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper lightgallery">
                        @foreach ($page->props['about_gallery'] as $image)
                            <a class="swiper-slide" href="{{ $image }}">
                                <img src="{{ $image }}" alt="Сертификаты">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button swiper-button-next">
                    @svg('images/svg/arrow.svg')
                </div>
            </div>
        </div>


        <div class="second-text">{{ $page->props['second_text'] }}</div>
        <div class="about-gallery">
            <div class="gallery-thumbs">
                <div class="swiper-button swiper-button-prev">
                    @svg('images/svg/arrow.svg')
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper lightgallery">
                        @foreach ($page->props['about_gallery_2'] as $image)
                            <a class="swiper-slide" href="{{ $image }}">
                                <img src="{{ $image }}" alt="Сертификаты">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button swiper-button-next">
                    @svg('images/svg/arrow.svg')
                </div>
            </div>
        </div>

        <div class="third-text">{{ $page->props['third_text'] }}</div>
        <div class="about-gallery">
            <div class="gallery-thumbs">
                <div class="swiper-button swiper-button-prev">
                    @svg('images/svg/arrow.svg')
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper lightgallery">
                        @foreach ($page->props['third_gallery'] ?? [] as $image)
                            <a class="swiper-slide" href="{{ $image }}">
                                <img src="{{ $image }}" alt="Сертификаты">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button swiper-button-next">
                    @svg('images/svg/arrow.svg')
                </div>
            </div>
        </div>


        <div class="order-form go-distrib">
            <div class="top-row">
                <h2 class="h2 h2-title">Хочу в семью AleVi</h2>
                <p>Оставьте заявку если хотите стать частью семьи AleVi</p>
            </div>
            <form @submit.prevent="submit" class="form-distributors form-row">
                <input type="hidden" :value="form.form = 'to_alevi_family'">
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
                <div class="f-wrap">
                    <input placeholder="text" type="text" autocomplete="address-level2" v-model="form.city" required>
                    <div class="f-placeholder">Ваш город</div>
                    @svg('images/svg/location.svg')
                </div>
                <div class="space"></div>
                <button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
                    <span :class="{ hidden: success }">Оставить заявку</span>
                    <span :class="{ hidden: !success }">Заявка принята</span>
                </button>
            </form>
        </div>

        <div class="go-distrib">
            <div class="h2 h2-title">Подписывайся на нас в соцсетях</div>
            <div class="distributors-grid">
                @foreach (range(1,4) as $i)
                    <div class="ds-item">
                        <div class="ds-avatar flex-center">
                            <img src="{{ $page->props['a_avatar_' . $i] }}" alt="">
                        </div>
                        <div class="right-col">
                            <div class="h3">{{ $page->props['a_name_' . $i] }}</div>
                            <div class="ds-city">{{ $page->props['a_position_' . $i] }}</div>
                            <div class="f-icons f-icons-partners">
                                @if ($page->props['a_vk_' . $i])
                                    <a href="{{ $page->props['a_vk_' . $i] }}">
                                        @svg('images/svg/vk.svg')
                                    </a>
                                @endif
                                @if ($page->props['a_instagram_' . $i])
                                    <a href="{{ $page->props['a_instagram_' . $i] }}">
                                        @svg('images/svg/instagram.svg')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection


@section('body_end')
    <script src="{{ mix('js/gallery.js', 'assets') }}" defer></script>
@endsection
