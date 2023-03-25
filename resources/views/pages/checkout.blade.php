@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_code')
    @vite('resources/front/js/checkout.js')
@endsection

@section('content')

<div class="checkout-box" id="checkout">
    <div class="container" :class="{'loading-blink': loading}">
        <div class="h2">@lang('front.cart_page.checkout_title')</div>
        <form @submit.prevent="submit" class="checkout-middle grid-2">
            <div class="checkout-list-col">
                <div class="checkout-list-white">
                    <div class="ow-title just-title">@lang('front.cart_page.your_checkout')</div>
                    <div class="checkout-list custom-scroll">
                        <div v-for="item in cart" class="checkout-item">
                            <div class="col-image">
                                <div class="prod-image wa-hover">
                                    <img :src="item.preview" alt="" loading="lazy">
                                </div>
                            </div>
                            <div class="col-name col-info">
                                <div class="checkout-name">@{{ item.name }}</div>
                                <div class="checkout-attr ch-mini"><span>@{{ item.options_string }}</span></div>
                            </div>
                            <div class="col-price col-info">
                                <div class="checkout-price">
                                    <b>
                                        <span class="price-el" data-cy="{{cy()}}">@{{ formatPrice(item.price * item.quantity) }}</span>
                                    </b>
                                </div>
                                <div class="checkout-quantity ch-mini">@lang('front.count'): <span>@{{ item.quantity }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="checkout-subtotal">
                        <div class="ct-row">
                            <div class="ct-name">@lang('front.cart_page.subtotal')</div>
                            <div class="ct-value"><span class="price-el" data-cy="{{cy()}}">@{{ formatPrice(subtotal) }}</span></div>
                        </div>

                        <div class="ct-row" v-for="c in conditions">
                            <div class="ct-name">@{{ c.type }}</div>
                            <div class="ct-value">@{{ c.value }}</div>
                        </div>
                    </div>
                    <div class="checkout-total ct-row just-title">
                        <div class="ct-name">@lang('front.cart_page.total')</div>
                        <div class="ct-value"><span class="price-el" data-cy="{{cy()}}">@{{ formatPrice(total) }}</span></div>
                    </div>
                </div>
                <div class="checkout-botom-row">
                    <a href="{{ localRoute('front.pages', 'cart') }}" class="btn btn-mini">@lang('front.cart_page.back_to_cart')</a>
                    <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg icon">
                </div>
            </div>
            <div class="checkout-contact-col checkout-form-col">
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.contact.contact_title')</div>
                    <div class="checkout-inputs grid-2">
                        <div class="form-input">
                            <input v-model="form.name" type="text" autocomplete="name" placeholder="@lang('front.contact.first_last_name')" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.phone" type="text" autocomplete="tel" placeholder="@lang('front.contact.phone')" ref="phone" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.email" type="email" autocomplete="email" placeholder="@lang('front.contact.email')" required>
                        </div>
                    </div>
                </div>
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.contact.address_title')</div>
                    <div class="checkout-inputs grid-2">
                        <div class="form-input">
                            <input v-model="form.address.country" type="text" autocomplete="country" placeholder="@lang('front.contact.country')" data-default="@lang('front.contact.default_country')" ref="country" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.address.region" type="text" autocomplete="address-level1" placeholder="@lang('front.contact.region')" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.address.city" type="text" autocomplete="address-level2" placeholder="@lang('front.contact.city')" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.address.street" type="text" autocomplete="address-line1" placeholder="@lang('front.contact.street_house_flat')" required>
                        </div>
                        <div class="form-input">
                            <input v-model="form.address.postcode" type="text" autocomplete="postal_code" placeholder="@lang('front.contact.postcode')" required>
                        </div>
                    </div>
                </div>
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.cart_page.payment_type')</div>
                    <div class="payment-method grid-2">
                        @foreach (config('payment.available_drivers') as $item)
                        <label class="pm-item">
                            <input type="radio" v-model="form.payment_type" value="{{ $item }}">
                            <span>{{ __('front.payment_types.'.$item) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="checkout-contact-col col-bottom">
                <div class="checkout-form-element">
                    <div class="ofe-bottom grid-2">
                        <button :disabled="loading" class="btn">@lang('front.cart_page.done_btn')</button>
                        <label class="pm-item">
                            <input type="checkbox" required checked>
                            <span>@lang('front.cart_page.policy_text') <a href="#" class="primary"><b>@lang('front.cart_page.policy_link')</b></a></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
