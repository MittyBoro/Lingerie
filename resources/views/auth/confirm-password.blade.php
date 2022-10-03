@extends('layouts.main')

@section('meta_title', 'Подтверждение пароля | ' . config('app.name'))

@section('content')

<div class="auth-box">
	<div class="container">

		<h1 class="h2 h2-title">Подтверждение пароля</h1>

		<form class="auth-form form-grid" method="POST" action="{{ route('password.confirm') }}">
			@csrf

			<div class="text-box">
				Это безопасная область приложения. Пожалуйста, подтвердите свой пароль, прежде чем продолжить.
			</div>

			@include('elements.error')

			<div class="f-wrap f-full">
				<input placeholder="text" type="password" autocomplete="current-password" name="password" required autofocus>
				<div class="f-placeholder">Пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<button class="btn">Подтвердить</button>
		</form>
	</div>
</div>

@endsection
