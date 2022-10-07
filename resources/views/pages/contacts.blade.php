@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="contacts-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>{{ $page['title'] }}</span>
        </div>

        <h1 class="h2 h2-title">{{ $page['title'] }}</h1>

        <div class="contact-grid">
            <div class="contact-info">
                <div class="director-cart">
                    <div class="avatar">
                        <img src="{{ $page->props['d_photo'] }}" alt="">
                    </div>
                    <div class="info">
                        <div class="h3 d-name">{{ $page->props['d_name'] }}</div>
                        <div class="d-info">Директор ТМ AleVi</div>
                        <div class="f-icons">
                            @if ($page->props['d_vk'])
                                <a target="_blank" href="{{ $page->props['d_vk'] }}">
                                    @svg('images/svg/vk.svg')
                                </a>
                            @endif
                            @if ($page->props['d_insta'])
                                <a target="_blank" href="{{ $page->props['d_insta'] }}">
                                    @svg('images/svg/instagram.svg')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="contact-el">
                    <div class="h3">По вопросам заказа продукции и сотрудничества:</div>
                    <div class="contact-mini contact-mini-first">
                        <a class="contact-a" href="{{ $page->props['email'] }}">
                            @svg('images/svg/email.svg')
                            <span>{{ $page->props['email'] }}</span>
                        </a>
                        <a class="contact-a" href="{{ $page->props['vk_manager'] }}">
                            @svg('images/svg/vk.svg')
                            <span>Менеджер</span>
                        </a>
                        <a class="contact-a" href="tel:{{ $props['phone'] }}">
                            @svg('images/svg/phone_round.svg')
                            <span>{{ $props['phone'] }}</span>
                        </a>
                        <a class="contact-a" href="{{ $page->props['vk_director'] }}">
                            @svg('images/svg/vk.svg')
                            <span>Исполнительный<br>директор</span>
                        </a>
                    </div>
                </div>
                <div class="contact-el">
                    <div class="h3">Управляющая компания:</div>
                    <div class="contact-mini">
                        <span class="contact-a">
                            @svg('images/svg/location.svg')
                            <span>{!! nl2br($page->props['upr_address']) !!}</span>
                        </span>
                        <a class="contact-a" href="{{ $page->props['upr_vk'] }}">
                            @svg('images/svg/vk.svg')
                            <span>Группа VK</span>
                        </a>
                    </div>
                </div>
                <div class="contact-el">
                    <div class="h3">Учебный центр:</div>
                    <div class="contact-mini">
                        <span class="contact-a">
                            @svg('images/svg/location.svg')
                            <span>{!! nl2br($page->props['u_address_1']) !!}</span>
                        </span>
                        <span class="contact-a">
                            @svg('images/svg/location.svg')
                            <span>{!! nl2br($page->props['u_address_2']) !!}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                <div id="map"></div>
            </div>
        </div>

    </div>
</div>

@endsection
