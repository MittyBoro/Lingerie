@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="order-box">
    <div class="container">
        <div class="order-list-col">
            <div class="ordet-title">Ваш заказ</div>
            <div class="order-list">
                @foreach (range(1, 3) as $i)
                    <div class="order-item">
                        <div class="order-image-col">
                            <img src="/storage/tmp/1.png" alt="">
                        </div>
                        <div class="order-info-col">
                            <div class="oi-top">
                                <div class="order-name">Длинный заголовок чудесного товара</div>
                                <div class="order-price"><span>6900</span> ₽</div>
                            </div>
                            <div class="oi-bottom">
                                <div class="order-attr"><span>Размер: XL</span></div>
                                <div class="order-quantity">Количество: <span>1</span></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="order-subtotal">
                <div class="os-row">
                    <div class="os-name">Подытог</div>
                    <div class="os-value">17 790 ₽</div>
                </div>
                <div class="os-row">
                    <div class="os-name">Доставка</div>
                    <div class="os-value">1500 ₽</div>
                </div>
            </div>
            <div class="order-total">
                <div class="os-name">Итог</div>
                <div class="os-value">19 290 ₽</div>
            </div>
        </div>
        <div class="order-contact-col">
            <div class="order-form-element">
                <div class="ordet-title">Контактная информация</div>
                <div class="order-inputs">
                    <div class="form-input">
                        <div class="form-title">Имя и фамилия</div>
                        <input type="text">
                    </div>
                    <div class="form-input">
                        <div class="form-title">Телефон</div>
                        <input type="text">
                    </div>
                    <div class="form-input">
                        <div class="form-title">E-Mail</div>
                        <input type="text">
                    </div>
                </div>
            </div>
            <div class="order-form-element">
                <div class="ordet-title">Адрес доставки</div>
                <div class="order-inputs">
                    <div class="form-input">
                        <div class="form-title">Улица, дом, квартира</div>
                        <input type="text">
                    </div>
                    <div class="form-input">
                        <div class="form-title">Населенный пункт</div>
                        <input type="text">
                    </div>
                    <div class="form-input">
                        <div class="form-title">Область / регион</div>
                        <input type="text">
                    </div>
                    <div class="form-input">
                        <div class="form-title">Почтовый индекс</div>
                        <input type="text">
                    </div>
                </div>
            </div>
            <div class="order-form-element">
                <div class="btn">перейти к оплате</div>
                <div class="of-info">Нажимая эту кнопку я соглашаюсь с <a href="#">Политикой конфиденциальности</a></div>
            </div>
        </div>
        <div class="order-botom-row">
            @svg('images/icons/alt-arrow.svg')
            <div class="btn btn-alt">вернуться в корзину</div>
        </div>
    </div>
</div>

@endsection
