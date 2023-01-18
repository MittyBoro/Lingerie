@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="order-box">
    <div class="container">
        <div class="h2">@lang('front.cart_page.checkout_title')</div>
        <div class="order-middle grid-2">
            <div class="order-list-col">
                <div class="order-list-white">
                    <div class="ow-title just-title">@lang('front.cart_page.your_order')</div>
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
                                    <div class="order-quantity o-mini">@lang('front.count'): <span>1</span></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="order-subtotal">
                        <div class="ot-row">
                            <div class="ot-name">@lang('front.cart_page.subtotal')</div>
                            <div class="ot-value">17 790 ₽</div>
                        </div>
                        {{-- <div class="ot-row">
                            <div class="ot-name">Скидка</div>
                            <div class="ot-value">1500 ₽</div>
                        </div> --}}
                        <div class="ot-row">
                            <div class="ot-name">@lang('front.cart_page.delivery')</div>
                            <div class="ot-value">1500 ₽</div>
                        </div>
                    </div>
                    <div class="order-total ot-row just-title">
                        <div class="ot-name">@lang('front.cart_page.total')</div>
                        <div class="ot-value">19 290 ₽</div>
                    </div>
                </div>
                <div class="order-botom-row">
                    <a href="/cart" class="btn btn-mini">@lang('front.cart_page.back_to_cart')</a>
                    <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg icon">
                </div>
            </div>
            <div class="order-contact-col order-form-col">
                <div class="order-form-element">
                    <div class="just-title">@lang('front.contact.contact_title')</div>
                    <div class="order-inputs grid-2">
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
                <div class="order-form-element">
                    <div class="just-title">@lang('front.contact.contact_title')</div>
                    <div class="order-inputs grid-2">
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
                <div class="order-form-element">
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
            <div class="order-contact-col col-bottom">
                <div class="order-form-element">
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
