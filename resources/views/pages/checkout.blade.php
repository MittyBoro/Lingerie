@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="checkout-box">
    <div class="container">
        <div class="h2">@lang('front.cart_page.checkout_title')</div>
        <div class="checkout-middle grid-2">
            <div class="checkout-list-col">
                <div class="checkout-list-white">
                    <div class="ow-title just-title">@lang('front.cart_page.your_checkout')</div>
                    <div class="checkout-list">
                        @foreach (range(1, 3) as $i)
                            <div class="checkout-item">
                                <div class="col-image">
                                    <div class="prod-image wa-hover">
                                        <img src="/storage/tmp/1.png" alt="">
                                    </div>
                                </div>
                                <div class="col-name col-info">
                                    <div class="checkout-name">Длинный заголовок чудесного товара</div>
                                    <div class="checkout-attr ch-mini"><span>Размер: XL</span></div>
                                </div>
                                <div class="col-price col-info">
                                    <div class="checkout-price"><b><span>6900</span> ₽</b></div>
                                    <div class="checkout-quantity ch-mini">@lang('front.count'): <span>1</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="checkout-subtotal">
                        <div class="ct-row">
                            <div class="ct-name">@lang('front.cart_page.subtotal')</div>
                            <div class="ct-value">17 790 ₽</div>
                        </div>
                        {{-- <div class="ct-row">
                            <div class="ct-name">Скидка</div>
                            <div class="ct-value">1500 ₽</div>
                        </div> --}}
                        <div class="ct-row">
                            <div class="ct-name">@lang('front.cart_page.delivery')</div>
                            <div class="ct-value">1500 ₽</div>
                        </div>
                    </div>
                    <div class="checkout-total ct-row just-title">
                        <div class="ct-name">@lang('front.cart_page.total')</div>
                        <div class="ct-value">19 290 ₽</div>
                    </div>
                </div>
                <div class="checkout-botom-row">
                    <a href="/cart" class="btn btn-mini">@lang('front.cart_page.back_to_cart')</a>
                    <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg icon">
                </div>
            </div>
            <div class="checkout-contact-col checkout-form-col">
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.contact.contact_title')</div>
                    <div class="checkout-inputs grid-2">
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.first_last_name')" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.phone')" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.email')" required>
                        </div>
                    </div>
                </div>
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.contact.contact_title')</div>
                    <div class="checkout-inputs grid-2">
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.street_house_flat')" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.city')" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.region')" required>
                        </div>
                        <div class="form-input">
                            <input type="text" placeholder="@lang('front.contact.postcode')" required>
                        </div>
                    </div>
                </div>
                <div class="checkout-form-element">
                    <div class="just-title">@lang('front.cart_page.payment_type')</div>
                    <div class="payment-method grid-2">
                        <label class="pm-item">
                            <input type="radio" name="pm" value="1">
                            <span>@lang('front.cart_page.card_payment')</span>
                        </label>
                        <label class="pm-item">
                            <input type="radio" name="pm" value="2">
                            <span>@lang('front.cart_page.upon_receipt')</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="checkout-contact-col col-bottom">
                <div class="checkout-form-element">
                    <div class="ofe-bottom grid-2">
                        <div class="btn">@lang('front.cart_page.done_btn')</div>
                        <label class="pm-item">
                            <input type="checkbox" name="pc" required checked>
                            <span>@lang('front.cart_page.policy_text') <a href="#" class="primary"><b>@lang('front.cart_page.policy_link')</b></a></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
