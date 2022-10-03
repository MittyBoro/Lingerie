@extends('layouts.main')

@section('meta_title', 'Восстановление пароля | ' . config('app.name'))

@section('content')

<div class="auth-box">
	<div class="container">

		<h1 class="h2 h2-title">Восстановление пароля</h1>

		<form class="auth-form form-grid" method="POST" action="{{ route('password.update') }}">
			@csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

			@include('elements.error')

			<div class="f-wrap f-full">
				<input placeholder="text" type="email" name="email" value="{{ old('email', $request->email) }}" required readonly>
				<div class="f-placeholder">Email</div>
				@svg('images/svg/email.svg')
			</div>

			<div class="f-wrap f-full">
				<input placeholder="text" type="password" name="password" required>
				<div class="f-placeholder">Новый пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<div class="f-wrap f-full">
				<input placeholder="text" type="password" name="password_confirmation" required>
				<div class="f-placeholder">Подтвердите пароль</div>
				@svg('images/svg/lock.svg')
			</div>

			<button class="btn">Изменить пароль</button>
		</form>

	</div>
</div>

@endsection
