@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="cart-box" id="cart">
    <div class="container">

        <h1 class="h2 h2-title" v-show="cartList.length || !ready">Корзина</h1>

        <div v-if="cartList.length || !ready" class="cart-content" :class="{ 'show-content': ready, loading: loading }">

            <div class="cart-table">
                <div class="table-head">
                    <div class="th-col">товар</div>
                    <div class="th-col"></div>
                    <div class="th-col">цена</div>
                    <div class="th-col">количество</div>
                    <div class="th-col">итого</div>
                    <div class="th-col"></div>
                </div>
                <div class="table-row" v-for="item in cartList" :key="item.id">
                    <div class="tr-col cart-img"><img :src="item.attributes.preview" alt=""></div>
                    <div class="tr-col cart-name">
                        <div class="h3"><a :href="'/product/' + item.attributes.slug">@{{ item.name }}</a></div>
                        <div class="variants" v-for="(attr, i) in item.attributes.variations" :key="i">
                            <template v-if="attr.name" >
                                <span>@{{ attr.name }}</span>: <span>@{{ attr.value }}</span>
                            </template>
                        </div>
                    </div>
                    <div class="tr-col cart-price">
                        <div v-if="item.discount_price">
                            <span>@{{ formatPrice(item.discount_price) }}</span>₽
                            <span class="old-price" v-text="formatPrice(item.price)"></span>
                        </div>
                        <div v-else>
                            <span>@{{ formatPrice(item.price) }}</span>₽
                        </div>
                    </div>
                    <div class="tr-col cart-count">
                        <div class="count-order">
                            <div class="minus" @click="item = setItemCount(item, -1)"></div>
                            <input :style="{ width: getWidth(item.quantity) }" type="number" min="1" v-model.lazy="item.quantity" @change="update(item)"/>
                            <div class="plus" @click="item = setItemCount(item, 1)"></div>
                        </div>
                    </div>
                    <div class="tr-col cart-price cart-price-total">
                        <div v-if="item.discount_price">
                            <span>@{{ formatPrice(item.discount_price * item.quantity) }}</span>₽
                            <span class="percent" v-text="item.percent"></span>
                        </div>
                        <div v-else>
                            <span>@{{ formatPrice(item.price * item.quantity) }}</span>₽
                        </div>
                    </div>
                    <div class="tr-col cart-remove">
                        <span @click="remove(item)">×</span>
                    </div>
                </div>
                <div class="subtotal-int">
                    <div class="si-line">
                        <span>Подытог: </span>
                        <span class="old-price" v-if="subtotalOld && subtotalOld != subtotal">
                            <span>@{{ subtotalOld }}</span>₽
                        </span>
                        <span>
                            <span>@{{ subtotal }}</span>₽
                        </span>
                    </div>
                    <div class="si-line si-bonuses" v-if="future_bonuses">
                        <span>Возврат: </span>
                        <span v-text="'Возврат: ' + bonusString(future_bonuses)"></span>
                    </div>
                </div>
            </div>

            <div class="subtotal-line">
                <a class="back-to-shop" href="/shop">
                    @svg('images/svg/arrow.svg')
                    <span>Продолжить покупки</span>
                </a>
                @auth
                    <div class="subtotal-int">
                        <span>Подытог: </span>
                        <span class="old-price" v-if="subtotalOld && subtotalOld != subtotal">
                            <span>@{{ subtotalOld }}</span>₽
                        </span>
                        <span>
                            <span>@{{ subtotal }}</span>₽
                        </span>
                        <div v-if="future_bonuses" class="si-bonuses" v-text="'Возврат: ' + bonusString(future_bonuses)"></div>
                    </div>
                    <a href="/checkout" class="btn">Оформить заказ</a>
                @endauth
            </div>

            @auth
                <form @submit.prevent="setPromocode" class="promocode-line">
                    <div v-if="promocode" class="active-code">
                        <span>Активный промокод: </span>
                        <span class="promocode">
                            <span v-text="promocode"></span>
                            <span class="clear" @click="clearPromocode">×</span>
                        </span>
                    </div>
                    <div class="text-promo-wrap">
                        <div class="haspromo">Имеется промокод?</div>
                        <div class="promocode-error" v-text="promoMessage"></div>
                    </div>
                    <div class="f-wrap">
                        <input placeholder="text" v-model="newPromocode" type="text">
                        <div class="f-placeholder">Введите промокод</div>
                    </div>
                    <button class="btn-mini">Применить</button>
                </form>

            @endauth

            @guest
                <div class="guest-info">
                    <div class="g-text">Только авторизованные пользователи могут оформить заказ</div>

                    <div class="btns-row">
                        <a href="/register" class="btn-mini">Регистрация</a>
                        <div class="space"></div>
                        <a href="/login" class="btn-mini btn-gray">Вход</a>
                    </div>
                </div>
            @endguest

        </div>

        <div v-else class="empty-cart" :class="{ 'show-content': ready }">
            <div class="h2">Пока в корзине ничего нет</div>
            <a href="/shop" class="btn btn-mini">К покупкам!</a>
        </div>


    </div>
</div>

@endsection
