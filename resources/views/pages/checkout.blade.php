@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="checkout-box" id="checkout">
    <div class="container">

        <h1 class="h2 h2-title">Доставка и оплата</h1>

        <div class="cb-container">
            <div class="left-list">
                <div class="ct-wrap">
                    <div class="h3">Ваш заказ</div>
                    <div class="cart-table">
                        @foreach ($cart as $item)
                            <div class="table-row">
                                <div class="tr-col cart-img"><img src="{{ $item->attributes->preview }}" alt=""></div>
                                <div class="tr-col cart-name">
                                    <div class="h4"><a href="/product/{{ $item->attributes->slug }}">{{ $item->name }}</a></div>
                                    @foreach ($item->attributes->variations as $attr)
                                        @if ( $attr['name'])
                                            <div class="variants"><span>{{ $attr['name'] }}</span>: <span>{{ $attr['value'] }}</span></div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="tr-col cart-price">
                                    <p>Цена: <span>{{ format_price($item->discount_price ?: $item->price) }}</span>₽</p>
                                    <p>Количество: <span>{{ $item->quantity }}</span></p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="cart-info" :class="{ready: ready}">
                        @if($bonusLimit)
                            <div class="ci-col you-can">
                                <div class="ciy-title">Вы можете потратить <span class="color">до {{ format_price($bonusLimit) }} {{ sklonenie($bonusLimit, ['бонусный рубль', 'бонусных рубля', 'бонусных рублей']) }}</span></div>
                                <form @submit.prevent="setBonuses" class="spend-bonus-line">
                                    <div class="f-wrap f-wrap-nano">
                                        <input placeholder="-" min="0" max="{{ $bonusLimit }}" v-model="newSpendingBonus" type="number" required>
                                        <div class="f-placeholder">Сколько потратить?</div>
                                    </div>
                                    <button class="btn-nano">Применить</button>
                                </form>
                            </div>
                        @endif

                        <div class="ci-col">
                            <div class="ci-title">Подытог</div>
                            <div class="ci-value"><span>{{ format_price($subtotal) }}</span>₽</div>
                        </div>
                        <div class="ci-col">
                            <div class="ci-title">Подвоз к ТК от склада AleVi</div>
                            <div class="ci-value">{{ format_price($delivery) }}₽</div>
                        </div>
                        @if ($promocode)
                            <div class="ci-col ci-discount">
                                <div class="ci-title">Промокод <span class="color">{{ $promocode }}</span></div>
                                <div class="ci-value">-<span>{{ format_price($discount) }}</span>₽</div>
                            </div>
                        @endif
                        <div class="ci-col ci-discount" v-if="spending_bonuses">
                            <div class="ci-title">Бонусные рубли</div>
                            <div class="ci-value"><span>@{{ formatPrice(spending_bonuses) }}</span>₽</div>
                        </div>
                        <div class="ci-col ci-total">
                            <div class="ci-title">Итог</div>
                            <div class="ci-value"><span>@{{ formatPrice(total) }}</span>₽</div>
                        </div>

                        @if ($futureBonuses)
                            <div class="ci-col ci-bonuses">
                                <div class="ci-title"></div>
                                <div class="ci-value">После покупки вам будет начислено <span class="color"><b>{{ format_price($futureBonuses) }}</b> {{ sklonenie($futureBonuses, ['бонусный рубль', 'бонусных рубля', 'бонусных рублей']) }}</span></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="subtotal-line">
                    <a href="/cart" class="back-to-shop">
                        @svg('images/svg/arrow.svg')
                        <span>Вернутся в корзину</span>
                    </a>
                </div>
            </div>
            <form @submit.prevent="create" class="right-form" :class="{ready: ready}">
                <div class="h3">Ваши контакты</div>
                <div class="form-grid">
                    <div class="f-wrap f-full">
                        <input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
                        <div class="f-placeholder">ФИО</div>
                        @svg('images/svg/user.svg')
                    </div>
                    <div class="f-wrap">
                        <input class="format-phone" placeholder="text" type="text" autocomplete="tel" v-model="phone" required ref="phone">
                        <div class="f-placeholder">Телефон</div>
                        @svg('images/svg/phone.svg')
                    </div>
                    <div class="f-wrap">
                        <input placeholder="text" type="email" autocomplete="email" v-model="form.email" required>
                        <div class="f-placeholder">Email</div>
                        @svg('images/svg/email.svg')
                    </div>
                </div>
                <div class="h3">
                    <div>Адрес доставки</div>
                    <div class="sub-h">(пункт выдачи транспортной компании или личный адрес при отправке почтой)</div>
                </div>
                <div class="form-grid f-address">
                    <div class="f-wrap">
                        <input placeholder="text" type="text" autocomplete="address-level1" v-model="form.region" required>
                        <div class="f-placeholder">Область / регион</div>
                        @svg('images/svg/location.svg')
                    </div>
                    <div class="f-wrap">
                        <input placeholder="text" type="text" autocomplete="address-level2" v-model="form.city" required>
                        <div class="f-placeholder">Населенный пункт</div>
                        @svg('images/svg/location.svg')
                    </div>
                    <div class="f-wrap">
                        <input placeholder="text" type="text" autocomplete="address-line1" v-model="form.street" required>
                        <div class="f-placeholder">Улица, дом, квартира</div>
                        @svg('images/svg/location.svg')
                    </div>
                    <div class="f-wrap">
                        <input placeholder="text" type="number" autocomplete="postal-code" v-model="form.postcode" maxlength="8" required>
                        <div class="f-placeholder">Почтовый индекс</div>
                        @svg('images/svg/location.svg')
                    </div>
                    <div class="f-wrap f-full">
                        <input placeholder="text" type="text" v-model="form.transport" required>
                        <div class="f-placeholder">Транспортная компания <span>(СДЭК, Почта или др.) </span></div>
                    </div>
                    <div class="f-wrap f-big">
                        <textarea placeholder="text" v-model="form.comment"></textarea>
                        <div class="f-placeholder">Примечания <span>к заказу </span><i>(необязательно)</i></div>
                        @svg('images/svg/pen.svg')
                    </div>
                </div>
                <div class="h3">Выберите способ оплаты</div>
                <div class="form-grid form-buttons">

                    <div class="f-full btn-item">
                        <button class="btn" :disabled="disabled" @click="setPaymentType('yookassa')">Оплатить онлайн</button>
                        <p>Обычный платёж Вашей банковской картой</p>
                    </div>
                    <div class="delimiter"></div>

                    <div v-show="!total || total >= 3000" class="f-full btn-item">
                        <button class="btn btn-yellow" :disabled="disabled" @click="setPaymentType('tinkoff')">Оплатить в рассрочку</button>
                        <p>Купите без оплаты прямо сейчас</p>
                        <p><a target="_blank" href="/tinkoff-info" class="color link">Подробности здесь</a></p>
                    </div>
                    <div v-show="!total || total >= 3000" class="delimiter"></div>

                    <div class="f-full btn-item">
                        <button class="btn btn-dark" :disabled="disabled" @click="setPaymentType('dolyame')">Оплатить долями</button>
                        <p>Оплачивайте покупки частями — по 25% каждые две недели</p>
                        <p>Никаких дополнительных платежей — как обычная оплата картой</p>
                        <p><a target="_blank" href="/dolyame-info" class="color link">Подробности здесь</a></p>
                    </div>
                    <div class="delimiter"></div>

                    <label class="agreement f-full">
                        <div>
                            <p>Нажимая кнопку оплаты Вы даете согласие на обработку Ваших персональных данных.</p>
                            <a href="/privacy-policy">Политика конфиденциальности</a>
                        </div>
                    </label>
                    <div class="sb-delivery f-full">
                        {!! $page->props['delivery_text'] ?? '' !!}
                    </div>
                </div>
            </form>
        </div>




    </div>
</div>

@endsection


@section('body_end')

<script>
    const CUSTOMER = @json($customer);
</script>

@endsection
