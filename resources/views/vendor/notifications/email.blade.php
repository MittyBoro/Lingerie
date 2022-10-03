@extends('layouts.email')

@if (!empty($greeting))
	@section('header', $greeting)
@else
	@if ($level === 'error')
		@section('header', 'Ошибка')
	@else
		@section('header', 'Здравствуйте!')
	@endif
@endif

@section('content')

{{-- Intro Lines --}}

@foreach ($introLines as $line)
	@include('elements.email.row_start')
		@lang($line)
	@include('elements.email.row_end')
@endforeach

{{-- Action Button --}}
@isset($actionText)
	@include('elements.email.button', ['button' => [
		'url' => $actionUrl,
		'text' => $actionText,
	]])
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
	@include('elements.email.row_start')
		@lang($line)
	@include('elements.email.row_end')
@endforeach


@isset($actionText)
	@include('elements.email.row_start')
		Если у вас возникли проблемы с нажатием кнопки «{{ $actionText }}», скопируйте URL и вставьте его в ваш веб-браузер:<br>
		<a style="font-size: 10px;" href="{{ $actionUrl }}">{{ $actionUrl }}</a>
	@include('elements.email.row_end')
@endisset

@endsection
