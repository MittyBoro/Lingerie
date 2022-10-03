@extends('layouts.email')

@section('header', $subject)

@section('content')

@php
	$keyStyle = 'white-space:nowrap; padding: 0 20px 9px 0; color: #999999;';
	$valueStyle = 'padding: 0 0 9px 0;';
	$prodTDStyle = 'padding: 10px 5px; background-color: #fdfaff; vertical-align: middle; border-bottom: 1px solid #e4d1f0; border-top: 1px solid #e4d1f0;';
@endphp

<table width="100%">
	<tbody>
		<tr>
			<td style="{!! $keyStyle !!}">Имя:</td>
			<td style="{!! $valueStyle !!}">{{ $order->name }}</td>
		</tr>
		<tr>
			<td style="{!! $keyStyle !!}">Телефон:</td>
			<td style="{!! $valueStyle !!}">{{ $order->phone }}</td>
		</tr>
		<tr>
			<td style="{!! $keyStyle !!}">Email:</td>
			<td style="{!! $valueStyle !!}">{{ $order->email }}</td>
		</tr>

		@if ($order->address)
			<tr>
				<td style="{!! $keyStyle !!}">Адрес:</td>
				<td style="{!! $valueStyle !!}">{{ $order->address['region'] }}, {{ $order->address['city'] }}, {{ $order->address['street'] }}</td>
			</tr>
			@if ($order->address['postcode'])
				<tr>
					<td style="{!! $keyStyle !!}">Индекс:</td>
					<td style="{!! $valueStyle !!}">{{ $order->address['postcode'] }}</td>
				</tr>
			@endif
			@if ($order->address['transport'])
				<tr>
					<td style="{!! $keyStyle !!}">Тр. компания:</td>
					<td style="{!! $valueStyle !!}">{{ $order->address['transport'] }}</td>
				</tr>
			@endif
		@endif

		@if ($order->comment)
			<tr>
				<td style="{!! $keyStyle !!}">Примечание:</td>
				<td style="{!! $valueStyle !!}">{!! nl2br($order->comment) !!}</td>
			</tr>
		@endif

		<tr>
			<td colspan="2" style="padding: 15px 0px;">
				<div style="border-top: 3px solid #FAF2FE;"></div>
			</td>
		</tr>

		@if ($order->promocode)
			<tr>
				<td style="{!! $keyStyle !!}">Промокод:</td>
				<td style="{!! $valueStyle !!}">{{ $order->promocode }}</td>
			</tr>
		@endif
		<tr>
			<td style="{!! $keyStyle !!}">Товары:</td>
			<td style="{!! $valueStyle !!}">{{ format_price($order->old_amount) }}₽</td>
		</tr>
		@if ($order->discounts)
			<tr>
				<td style="{!! $keyStyle !!}">Скидки:</td>
				<td style="opacity: 0.7; {!! $valueStyle !!} ">{{ format_price($order->discounts) }}₽</td>
			</tr>
		@endif
		<tr>
			<td style="{!! $keyStyle !!}">Доставка:</td>
			<td style="{!! $valueStyle !!}">{{ format_price($order->delivery) }}₽</td>
		</tr>
		<tr>
			<td style="{!! $keyStyle !!} vertical-align: middle;">Итого:</td>
			<td style="{!! $valueStyle !!}">
				<span style="display: inline-block; background-color: #C790E7; color: #ffffff; padding: 2px 8px; font-weight: 600">
					{{ format_price($order->amount) }}₽
				</span>
			</td>
		</tr>
	</tbody>
</table>

<h2 class="v-font-size" style="margin: 30px 0px 15px; line-height: 130%; text-align: left; word-wrap: break-word; font-weight: normal; font-family: 'Montserrat',sans-serif; font-size: 16px; font-weight: 600;">
	Подробности заказа:
</h2>

<table width="100%" style="width: 100%; border: 1px solid #e4d1f0">
	<tbody>
		@foreach ($order->items as $item)
			<tr>
				<td class="mobile-none" style="{!! $prodTDStyle !!} padding-left: 15px; padding-right: 0; width: 1%; max-weight: 65px;">
					<img src="{{ $item->product->preview }}"
					style="display:block; width: 50px; min-width: 50px; max-width: 50px; height: 50px; max-height: 50px; " alt="">
				</td>
				<td style="{!! $prodTDStyle !!} padding-left: 15px;">
					<a style="font-weight: 600; font-size: 90%;" target="_blank" href="{{ route('front.pages', ['product', $item->product->slug]) }}">{{ $item->name }}</a>
					@if (is_array($item->variations))
						@foreach ($item->variations as $attr)
							@if ( $attr['name'] )
								<div style="font-size: 80%;">
									<span>{{ $attr['name'] }}</span>: <span>{{ $attr['value'] }}</span>
								</div>
							@endif
						@endforeach
					@endif
				</td>
				<td style="{!! $prodTDStyle !!} font-size: 80%; padding-right: 15px; min-width: 100px;">
					<div>
						<span style="display: inline-block;">Цена: </span>
						<span style="display: inline-block;">
							<span >{{ format_price($item->discount_price) }}₽</span>
							@if ($item->discount_price != $item->price)
								<span style="color: #999999; text-decoration: line-through; font-size: 70%">{{ format_price($item->price) }}₽</span>
							@endif
						</span>
					</div>
					<div>
						<span style="display: inline-block;">Кол-во: </span>
						<span>{{ $item->quantity }}</span>
					</div>
					<div>
						<span style="display: inline-block;">Стоимость: </span>
						<span style="display: inline-block; font-weight: 600">{{ format_price(($item->discount_price ?: $item->price) * $item->quantity) }}₽</span>
					</div>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection
