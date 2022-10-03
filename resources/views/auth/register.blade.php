@extends('layouts.main')

@section('meta_title', 'Регистрация | ' . config('app.name'))

@section('content')

<div class="auth-box">
	<div class="container">

		<h1 class="h2 h2-title">Регистрация</h1>

		<form class="auth-form form-grid" method="POST" action="{{ route('register') }}">
			@csrf

			@include('elements.error')

			<div class="f-wrap f-full">
				<input placeholder="text" type="text" name="name" value="{{ old('name') }}" autocomplete="name" required>
				<div class="f-placeholder">Ваше имя</div>
				@svg('images/svg/user.svg')
			</div>

			<div class="f-wrap f-full">
				<input placeholder="text" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required>
				<div class="f-placeholder">Email</div>
				@svg('images/svg/email.svg')
			</div>

			<div class="f-wrap f-full">
				<input class="format-phone" placeholder="text" type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel" required>
				<div class="f-placeholder">Телефон</div>
				@svg('images/svg/phone.svg')
			</div>


			<div class="f-wrap f-full">
				<input placeholder="text" type="password" name="password" required>
				<div class="f-placeholder">Пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<div class="f-wrap f-full">
				<input placeholder="text" type="password"name="password_confirmation" required>
				<div class="f-placeholder">Подтвердите пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<button class="btn">Зарегистрироваться</button>

			<label class="agreement">
				<div>
					<p>Нажимая кнопку «Зарегистрироваться» вы даете согласие на обработку ваших персональных данных.</p>
					<a href="/privacy-policy">Политика конфиденциальности</a>
				</div>
			</label>

			<div class="other-links">
				<a href="/login">Уже зарегистрированы?</a>
			</div>
		</form>

	</div>
</div>

@endsection
