@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="order-box">
    <div class="container">
        <div class="h2">Оформление<i></i> заказа</div>
        <div class="order-middle grid-2">
            <div class="order-list-col">
                <div class="order-list-white">
                    <div class="ow-title just-title">Ваш заказ</div>
                    <div class="order-list">
                        @foreach (range(1, 3) as $i)
                            <div class="order-item">
                                <div class="col-image">
                                    <div class="prod-image wa-hover">
                                        <img src="/storage/tmp/1.png" alt="">
                                    </div>
                                </div>
                                <div class="col-name col-info">
                                    <div class="order-name">Длинный заголовок чудесного товара</div>
                                    <div class="order-attr o-mini"><span>Размер: XL</span></div>
                                </div>
                                <div class="col-price col-info">
                                    <div class="order-price"><b><span>6900</span> ₽</b></div>
                                    <div class="order-quantity o-mini">Количество: <span>1</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="order-subtotal">
                        <div class="ot-row">
                            <div class="ot-name">Подытог</div>
                            <div class="ot-value">17 790 ₽</div>
                        </div>
                        <div class="ot-row">
                            <div class="ot-name">Скидка</div>
                            <div class="ot-value">1500 ₽</div>
                        </div>
                        <div class="ot-row">
                            <div class="ot-name">Доставка</div>
                            <div class="ot-value">1500 ₽</div>
                        </div>
                    </div>
                    <div class="order-total ot-row just-title">
                        <div class="ot-name">Итог</div>
                        <div class="ot-value">19 290 ₽</div>
                    </div>
                </div>
                <div class="order-botom-row">
                    <a href="/cart" class="btn btn-mini">вернуться в корзину</a>
                    <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg icon">
                </div>
            </div>
            <div class="order-contact-col order-form-col">
                <div class="order-form-element">
                    <div class="just-title">Контактная информация</div>
                    <div class="order-inputs grid-2">
                        <div class="form-input">
                            <input type="text" placeholder="Имя и фамилия" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="Телефон" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="E-Mail" required>
                        </div>
                    </div>
                </div>
                <div class="order-form-element">
                    <div class="just-title">Адрес доставки</div>
                    <div class="order-inputs grid-2">
                        <div class="form-input">
                            <input type="text" placeholder="Улица, дом, квартира" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="Населенный пункт" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="Область / регион" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="Почтовый индекс" required>
                        </div>
                    </div>
                </div>
                <div class="order-form-element">
                    <div class="just-title">Способ оплаты</div>
                    <div class="payment-method grid-2">
                        <label class="pm-item">
                            <input type="radio" name="pm" value="1">
                            <span>Банковская карта</span>
                        </label>
                        <label class="pm-item">
                            <input type="radio" name="pm" value="2">
                            <span>При получении</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="order-contact-col col-bottom">
                <div class="order-form-element">
                    <div class="ofe-bottom grid-2">
                        <div class="btn">Оформить заказ</div>
                        <label class="pm-item">
                            <input type="checkbox" name="pc" required checked>
                            <span>Нажимая эту кнопку я соглашаюсь с <a href="#" class="primary"><b>Политикой конфиденциальности</b></a></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
