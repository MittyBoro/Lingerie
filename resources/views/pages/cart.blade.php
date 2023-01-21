@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="cart-box">
    <div class="container">
        <div class="h2">@lang('front.cart_page.cart_title')</div>
        <div class="cart-list">
            @foreach (range(1, 3) as $i)
                <div class="cart-item grid-12">
                    <div class="cart-image-col">
                        <div class="prod-image wa-hover"><img src="/storage/tmp/1.png" alt=""></div>
                    </div>
                    <div class="cart-name-col c-text-col">
                        <div class="cart-name">Длинный заголовок чудесного товара</div>
                        <div class="cart-attr gray"><span>Размер: XL</span></div>
                    </div>
                    <div class="cart-count-col c-text-col">
                        <div class="c-ints-row">
                            <span class="circle minus"></span>
                            <span class="int" contenteditable>1</span>
                            <span class="circle plus"></span>
                        </div>
                    </div>
                    <div class="cart-price-col c-text-col">
                        <div class="cart-price"><span>6900</span> ₽</div>
                        <div class="cart-remove gray a">
                            <span>Удалить</span>
                            <img src="@vite_asset('images/icons/mini-close.svg')" alt="" class="to-svg icon">
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="cart-subtotal-row grid-12">
                <div class="cart-sb-name">@lang('front.cart_page.subtotal')</div>
                <div class="cart-price"><span>17 790</span> ₽</div>
                <div class="btn">@lang('front.cart_page.checkout')</div>
            </div>
        </div>
    </div>
</div>

@endsection
