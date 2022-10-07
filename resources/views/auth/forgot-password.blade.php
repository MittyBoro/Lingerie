@extends('layouts.main')

@section('meta_title', 'Восстановление пароля | ' . config('app.name'))

@section('content')

<div class="auth-box">
    <div class="container">

        <h1 class="h2 h2-title">Восстановление пароля</h1>

        <form class="auth-form form-grid" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="text-box">
                Забыли пароль? Нет проблем. Просто сообщите Ваш email-адрес и мы пришлём Вам ссылку для сброса пароля.
            </div>

            @include('elements.error')

            @if (session('status'))
                <div class="information-text">
                    {{ session('status') }}
                </div>
            @endif

            <div class="f-wrap f-full">
                <input placeholder="text" type="email" autocomplete="email" name="email" value="{{ old('email') }}" required autofocus>
                <div class="f-placeholder">Email</div>
                @svg('images/svg/email.svg')
            </div>

            <button class="btn">Сбросить пароль</button>

            <div class="other-links">
                <a href="/login">Вход</a>
            </div>
        </form>

    </div>
</div>

@endsection
