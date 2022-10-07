@extends('layouts.main')

@section('meta_title', 'Заказ #' . $order->id .' | ' . config('app.name'))

@section('content')

<div class="profile-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <a href="/profile">Личный кабинет</a> /
            <span>Заказ #{{ $order->id }}</span>
        </div>


        <div class="profile-wrap order-wrap">
            <div class="top-row">
                <div class="h3 simple-font">Заказ #{{ $order->id }}</div>
                <div class="right-row">
                    @if ($order->url)
                        <a target="_blank" href="{{ $order->url }}" class="btn-nano">Оплатить</a>
                    @endif
                    <div class="status {{ $order->status }}">
                        @lang($order->status)
                    </div>
                </div>
            </div>


            <div class="customer-info">
                <div class="ci-title">Дата:</div>
                <div><span data-format-datetime="{{ $order->created_at }}">{{ format_datetime($order->created_at) }}</div></span>
                <div class="ci-title">Имя:</div>
                <div>{{ $order->name }}</div>

                <div class="ci-title">Телефон:</div>
                <div>{{ $order->phone }}</div>

                <div class="ci-title">Email:</div>
                <div>{{ $order->email }}</div>

                @if ($order->address)
                    <div class="ci-title">Адрес:</div>
                    <div>{{ $order->address['region'] }}, {{ $order->address['city'] }}, {{ $order->address['street'] }}</div>

                    @if ($order->address['postcode'])
                        <div class="ci-title">Индекс:</div>
                        <div>{{ $order->address['postcode'] }}</div>
                    @endif

                    @if ($order->address['transport'])
                        <div class="ci-title">Тр. компания:</div>
                        <div>{{ $order->address['transport'] }}</div>
                    @endif
                @endif

                @if ($order->comment)
                    <div class="ci-title">Примечание:</div>
                    <div>{!! nl2br($order->comment) !!}</div>
                @endif


                <div class="ci-line"></div>

                @if ($order->promocode)
                    <div class="ci-title">Промокод:</div>
                    <div>{{ $order->promocode }}</div>
                @endif

                <div class="ci-title">Товары:</div>
                <div>{{ format_price($order->old_amount) }}₽</div>

                @if ($order->discounts)

                    <div class="ci-title">Скидки:</div>
                    <div class="ci-discount">{{ format_price($order->discounts) }}₽</div>
                @endif

                <div class="ci-title">Доставка:</div>
                <div>{{ format_price($order->delivery) }}₽</div>

                <div class="ci-title">Итого:</div>
                <div class="ci-total">{{ format_price($order->amount) }}₽</div>
            </div>

            <div class="product-list">
                @foreach ($order->items as $item)
                    <div class="product-item">
                        <img src="{{ $item->product->preview }}" alt="">

                        <div>
                            <a target="_blank" href="/product/{{$item->product->slug }}">{{ $item->name }}</a>
                            @foreach ($item->variations as $attr)
                                @if ( $attr['name'] )
                                    <div>
                                        <span>{{ $attr['name'] }}</span>: <span>{{ $attr['value'] }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="buy-info">
                            <div>
                                <span>Цена: </span>
                                @if($item->discount_price != $item->price)
                                    <span >{{ format_price($item->discount_price) }}₽</span>
                                    <span class="old-price">{{ format_price($item->price) }}₽</span>
                                @else
                                    <span >{{ format_price($item->price) }}₽</span>
                                @endif
                            </div>
                            <div>Количество: <span>{{ $item->quantity }}</span></div>
                            <div>Стоимость: <span class="font-semibold">{{ format_price($item->sum_price) }}₽</span></div>
                        </div>
                    </div>

                @endforeach
            </div>

        </div>

    </div>
</div>

@endsection
