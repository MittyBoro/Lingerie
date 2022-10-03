@extends('layouts.main')

@section('meta_title', 'Подтверждение email | ' . config('app.name'))

@section('content')

<div class="auth-box">
	<div class="container">

		<h1 class="h2 h2-title">Подтверждение email</h1>

		<div class="auth-form form-grid" method="POST" action="{{ route('verification.send') }}">

			<div class="text-box">
				Спасибо за регистрацию! Прежде чем начать – подтвердите свой email, перейдя по ссылке, которую мы только что отправили вам по электронной почте. Если вы не получили электронное письмо, мы с радостью вышлем вам другое.
			</div>

			@if (session('status') == 'verification-link-sent')
				<div class="information-text">
					На ваш email была отправлена новая ссылка для подтверждения.
				</div>
			@endif

			@include('elements.error')

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
				<button class="btn btn-mini">Выслать письмо повторно</button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
				<button class="btn btn-mini btn-gray">Выход</button>
            </form>
		</div>

	</div>
</div>

@endsection
