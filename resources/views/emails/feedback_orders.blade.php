@extends('layouts.email')

@section('header', $subject)

@section('content')

@php
	$keyStyle = 'white-space:nowrap; padding: 0 20px 9px 0; color: #999999;';
@endphp

<table>
	<tbody>
		@if ($order->name)
			<tr>
				<td style="{!! $keyStyle !!}">Имя:</td>
				<td>{{ $order->name }}</td>
			</tr>
		@endif
		@if ($order->phone)
			<tr>
				<td style="{!! $keyStyle !!}">Телефон:</td>
				<td>{{ $order->phone }}</td>
			</tr>
		@endif
		@if ($order->email)
			<tr>
				<td style="{!! $keyStyle !!}">Email:</td>
				<td>{{ $order->email }}</td>
			</tr>
		@endif
		@if ($order->city)
			<tr>
				<td style="{!! $keyStyle !!}">Город:</td>
				<td>{{ $order->city }}</td>
			</tr>
		@endif
		@if ($order->comment)
			<tr>
				<td style="{!! $keyStyle !!}">Примечание:</td>
				<td>{!! nl2br($order->comment) !!}</td>
			</tr>
		@endif
	</tbody>
</table>

@endsection
