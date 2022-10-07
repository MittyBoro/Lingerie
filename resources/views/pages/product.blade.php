@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('meta_type', 'product')
@section('meta_image', $product->preview)

@section('content')

<div class="prouct-box">
    <div class="container">
        <div class="back-to-catalog">
            <a href="/shop">@svg('images/svg/arrow.svg') назад в каталог</a>
        </div>

        <div class="breadcrumb breadcrumb-top">
            <a href="/">Главная</a> /
            <a href="/shop">Каталог</a> /
            @if ($category)
                <a href="/category/{{ $category->slug }}">{{ $category->title }}</a> /
            @endif
            <span>{{ $product->title }}</span>
        </div>

        <div class="product-content">

            @if ($product->gallery->isNotEmpty())
                <div class="prod-gallery">
                    <div class="gallery-top">
                        <div class="swiper-container">
                            <div class="swiper-wrapper lightgallery">
                                @foreach ($product->gallery as $image)
                                    <a class="swiper-slide" href="{{ $image['big'] }}">
                                        <div class="prod-zoom-image" style="background-image: url({{ $image['big'] }})">
                                            <img src="{{ $image['medium'] }}" alt="{{ $product->title }}">
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="gallery-thumbs">
                        <div class="swiper-button swiper-button-prev">
                            @svg('images/svg/arrow.svg')
                        </div>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($product->gallery as $image)
                                    <div class="swiper-slide">
                                        <img src="{{ $image['thumb'] }}" alt="{{ $product->title }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-button swiper-button-next">
                            @svg('images/svg/arrow.svg')
                        </div>
                    </div>
                </div>
            @endif

            <div class="prod-right" id="product">
                <div class="breadcrumb">
                    <a href="/">Главная</a> /
                    <a href="/shop">Каталог</a> /
                    @if ($category)
                        <a href="/category/{{ $category->slug }}">{{ $category->title }}</a> /
                    @endif
                    <span>{{ $product->title }}</span>
                </div>

                <div class="title-price">
                    <h1 class="h1">{{ $page->title }}</h1>
                    <div class="price-wrap">

                        <div class="prod-price">
                            @if ($product->is_stock)
                                <span v-text="formatPrice(price)" data-price="{{ $product->avg_price }}"></span>₽
                            @else
                                <span class="not-available">Снято с производства</span>
                            @endif
                        </div>
                        <div v-if="bonuses" class="prod-bonuses" v-text="'+' + formatPrice(bonuses) + sklonenie(bonuses, [' бонусный рубль', ' бонусных рубля', ' бонусных рублей'])">
                        </div>
                    </div>
                </div>

                <div class="prod-tabs">
                    @if($product->description)
                        <div :class="{active: activeTab == 1}" @click="setTab(1)">Описание</div>
                    @endif
                    @if($product->characteristics)
                        <div :class="{active: activeTab == 2}" @click="setTab(2)">Детали</div>
                    @endif
                    <div :class="{active: activeTab == 3}" @click="setTab(3)">Доставка</div>
                </div>

                <div class="prod-text-container">
                    <div :class="{active: activeTab == 1}" class="prod-description">
                        {!! $product->description !!}
                    </div>

                    @if($product->characteristics)
                        <div :class="{active: activeTab == 2}" class="prod-details">
                            @foreach ($product->characteristics as $item)
                                <div class="pd-col pd-col-first">{{ $item['name'] }}:</div>
                                <div class="pd-col">{{ $item['value'] }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div :class="{active: activeTab == 3}" class="prod-delivery">
                        {!! nl2br($props['shipping_text']) !!}
                    </div>
                </div>

                @if ($product->is_stock)
                    <div v-show="product.variations.length > 1" class="prod-variations">
                        <div v-for="(item, i) in variations" :key="i" class="pv-group">
                            <div v-show="item.name && item.name != '-'" class="pv-name" v-text="item.name + ':'"></div>
                            <div class="pv-val-group">
                                <label v-for="(val, i2) in item.values" :key="val.id" class="pv-value">
                                    <input type="radio" :value="val" v-model='activeVariations[i]'>
                                    <span v-text="val.value"></span>
                                </label>
                            </div>
                        </div>
                        <div class="pv-group">
                            <div class="pv-name">Количество</div>
                            <div class="pv-value count-order">
                                <div class="minus" @click=" (count <= 1) || (count -= 1)"></div>
                                <input :style="{ width: getWidth(count) }" type="number" min="1" v-model="count" id="count-order-val" />
                                <div class="plus" @click="count += 1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="btn btn-mini btn-double" :class="{ 'btn-disabled btn-animate': disabled, 'btn-success': success,  }" @click="addToCart">
                        <span :class="{ hidden: success }">Добавить в корзину</span>
                        <span :class="{ hidden: !success }">Добавлено</span>
                    </div>

                    <div class="payment-info text-box">
                        <p>При покупке данного товара Вы можете забрать заказ, оплатив только 25% цены, <a target="_blank" href="/dolyame-info" class="color-link">подробности здесь</a></p>
                        <p>Или можете купить товар <a target="_blank" href="/tinkoff-info" class="color-link">в рассрочку</a> на более гибких условиях</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>


<div class="product-catalog">
    <div class="container">
        <h2 class="h2 h2-title">С этим товаром покупают</h2>
        @include('elements.four_products', ['products' => $similar])
    </div>
</div>


@endsection

@section('body_end')
    <script src="{{ mix('js/gallery.js', 'assets') }}" defer></script>
    <script>
        const PRODUCT = @json($product->json);
    </script>
@endsection
