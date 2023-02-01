@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('headcode')
    @vite('resources/front/js/cart.js')
@endsection

@section('content')

<div class="cart-box" id="cart">
    <div class="container" :class="{'loading-blink': loading}">
        <div v-if="cart.length" class="h2">@lang('front.cart_page.cart_title')</div>
        <div v-if="cart.length" class="cart-list">
            <div v-for="item in cart" class="cart-item grid-12">
                <div class="cart-image-col">
                    <div class="prod-image wa-hover"><img :src="item.preview" alt=""></div>
                </div>
                <div class="cart-name-col c-text-col">
                    <a :href="item.url" class="cart-name">@{{ item.name }}</a>
                    <div class="cart-attr gray">
                        <span v-for="opt in item.options">@{{ opt.string }}</span>
                    </div>
                </div>
                <div class="cart-count-col c-text-col">
                    <div class="c-ints-row">
                        <span class="circle minus" @click="setItemCount(item, -1)"></span>
                        <span class="int" >@{{ item.quantity }}</span>
                        <span class="circle plus" @click="setItemCount(item, 1)"></span>
                    </div>
                </div>
                <div class="cart-price-col c-text-col">
                    <div class="cart-price">
                        <span class="price-el" data-cy="{{cy()}}">@{{ formatPrice(item.price * item.quantity) }}</span>
                    </div>
                    <div class="cart-remove gray a" @click="destroy(item)">
                        <span>@lang('front.remove')</span>
                        <img src="@vite_asset('images/icons/mini-close.svg')" alt="" class="to-svg icon">
                    </div>
                </div>
            </div>
            <div class="cart-subtotal-row grid-12">
                <div class="cart-sb-name">@lang('front.cart_page.subtotal')</div>
                <div class="cart-price">
                    <span class="price-el" data-cy="{{cy()}}">@{{ formatPrice(subtotal) }}</span>
                </div>
                <a href="/checkout" class="btn">@lang('front.cart_page.checkout')</a>
            </div>
        </div>
        <div v-else class="cart-empty white-box">
            <div class="white-item">
                <div class="h2">@lang('front.cart_page.cart_empty')</div>
                <a href="/catalog" class="btn">@lang('front.to_catalog')</a>
            </div>
        </div>
    </div>
</div>

@endsection
