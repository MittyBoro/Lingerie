@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="cart-box">
    <div class="container">
        <div class="h2">ваша корзина</div>
        <div class="cart-list">
            @foreach (range(1, 3) as $i)
                <div class="cart-item">
                    <div class="cart-image-col">
                        <img src="/storage/tmp/1.png" alt="">
                    </div>
                    <div class="cart-name-col">
                        <div class="cart-name">Длинный заголовок чудесного товара</div>
                        <div class="cart-attr"><span>Размер: XL</span></div>
                    </div>
                    <div class="cart-count">
                        <span class="circle">-</span>
                        <span class="int">1</span>
                        <span class="circle">+</span>
                    </div>
                    <div class="cart-price-col">
                        <div class="cart-price"><span>6900</span> ₽</div>
                        <div class="cart-remove">Удалить</div>
                    </div>
                </div>
            @endforeach
            <div class="cart-item cart-subtotal-row">
                <div class="cart-sb-name">Подытог</div>
                <div class="cart-price"><span>17 790</span> ₽</div>
                <div class="btn">оформить заказ</div>
            </div>
        </div>
    </div>
</div>

@endsection
