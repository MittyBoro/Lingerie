@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="cart-box">
    <div class="container">
        <div class="h2">ваша<i></i> корзина</div>
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
                        <div class="cart-remove gray a">Удалить</div>
                    </div>
                </div>
            @endforeach
            <div class="cart-subtotal-row grid-12">
                <div class="cart-sb-name">Подытог</div>
                <div class="cart-price"><span>17 790</span> ₽</div>
                <div class="btn">оформить заказ</div>
            </div>
        </div>
    </div>
</div>

@endsection
