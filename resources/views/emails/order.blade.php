@extends('layouts.email')

@section('header', $subject)

@section('content')

@php
    $keyStyle = 'white-space:nowrap; padding: 4px 20px 4px 0; color: #999999;';
    $valueStyle = 'padding: 4px 0 4px 0;';
    $prodTDStyle = 'padding: 10px 5px; background-color: #fff; vertical-align: middle; border-bottom: 1px solid #eeeeee; border-top: 1px solid #eeeeee;';
@endphp

<table width="100%">
    <tbody>
        <tr>
            <td style="{!! $valueStyle !!}">{{ $order->name }}</td>
        </tr>
        <tr>
            <td style="{!! $valueStyle !!}">{{ $order->phone }}</td>
        </tr>
        <tr>
            <td style="{!! $valueStyle !!}">{{ $order->email }}</td>
        </tr>

        @if ($order->address)
            <tr>
                <td style="{!! $valueStyle !!}">
                    {{ $order->address['country'] ?? '' }},
                    {{ $order->address['region'] ?? '' }},
                    {{ $order->address['city'] ?? '' }},
                    {{ $order->address['street'] ?? '' }},
                    {{ $order->address['postcode'] ?? '' }}
                <td>
            </tr>
        @endif

        <tr>
            <td style="padding: 15px 0px;">
                <div style="border-top: 3px solid #eeeeee;"></div>
            </td>
        </tr>

        <tr>
            <td style="{!! $valueStyle !!}">
                <span style=" color: #999999;">@lang('front.cart_page.total'): </span>
                <span style="display: inline-block; background-color: {{ $primaryColor }}; color: #ffffff; padding: 2px 8px; font-weight: 600">
                    {{ format_price($order->amount) }} {{ cySymb($order->currency) }}
                </span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px 0px;">
                <div style="border-top: 3px solid #eeeeee;"></div>
            </td>
        </tr>
    </tbody>
</table>

<table width="100%" style="width: 100%; border: 1px solid #eeeeee">
    <tbody>
        @foreach ($order->items as $item)
            <tr>
                <td class="mobile-none" style="{!! $prodTDStyle !!} padding-left: 15px; padding-right: 0; width: 1%; max-weight: 65px;">
                    @if($item->product)
                        <img src="{{ $item->product->preview }}"
                        style="display:block; width: 50px; min-width: 50px; max-width: 50px; height: 50px; max-height: 50px; " alt="">
                    @endif
                </td>
                <td style="{!! $prodTDStyle !!} padding-left: 15px;">
                    @if($item->product)
                        <a style="font-weight: 600; font-size: 90%;" target="_blank" href="{{ route('front.products', [$order->lang, $item->product->slug]) }}">{{ $item->name }}</a>
                    @else
                        <span>{{ $item->name }}</span>
                    @endif
                    @if (is_array($item->options))
                        @foreach ($item->options as $attr)
                            @if ( $attr['string'] )
                                <div style="font-size: 80%;">{{ $attr['string'] }}</div>
                            @endif
                        @endforeach
                    @endif
                </td>
                <td style="{!! $prodTDStyle !!} font-size: 80%; padding-right: 15px; min-width: 100px;">
                    <div>
                        <span style="display: inline-block;">Цена: </span>
                        <span style="display: inline-block;">
                            <span >{{ format_price($item->price) }} {{ cySymb($order->currency) }}</span>
                        </span>
                    </div>
                    <div>
                        <span style="display: inline-block;">Кол-во: </span>
                        <span>{{ $item->quantity }}</span>
                    </div>
                    <div>
                        <span style="display: inline-block;">Стоимость: </span>
                        <span style="display: inline-block; font-weight: 600">{{ format_price(($item->discount_price ?: $item->price) * $item->quantity) }} {{ cySymb($order->currency) }}</span>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
