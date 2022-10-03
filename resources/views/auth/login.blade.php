@extends('layouts.main')

@section('meta_title', 'Вход | ' . config('app.name'))

@section('content')

<div class="auth-box">
	<div class="container">

		<h1 class="h2 h2-title">Вход</h1>

		<form class="auth-form form-grid" method="POST" action="{{ route('login') }}">
			@csrf

			@include('elements.error')

			@if (session('status'))
				<div class="information-text">
					{{ session('status') }}
				</div>
			@endif

			<div class="f-wrap f-full">
				<input placeholder="text" type="text" autocomplete="email" name="login"  value="{{ old('login') }}" required>
				<div class="f-placeholder">Email</div>
				@svg('images/svg/email.svg')
			</div>

			<div class="f-wrap f-full">
				<input placeholder="text" type="password" autocomplete="password" name="password" required>
				<div class="f-placeholder">Пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<label class="remember-me">
				<input type="checkbox" name="remember">
				<span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
			</label>

			<button class="btn">Вход</button>

			<label class="agreement">
				<div>
					<p>Нажимая кнопку «Вход» вы даете согласие на обработку ваших персональных данных.</p>
					<a href="/privacy-policy">Политика конфиденциальности</a>
				</div>
			</label>

			<div class="other-links">
				<a href="/forgot-password">Забыли пароль?</a>
				<div class="space"></div>
				<a href="/register">Регистрация</a>
			</div>
		</form>

	</div>
</div>

@endsection
