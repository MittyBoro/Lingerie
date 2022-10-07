@extends('layouts.main')

@section('meta_title', 'Редактировать данные | ' . config('app.name'))

@section('content')

<div class="profile-box ">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <a href="/profile">Личный кабинет</a> /
            <span>Редактировать</span>
        </div>

        @if (session('status') || $errors->isNotEmpty())
            <div class="information-row">
                @include('elements.error')
                @if (session('status'))
                    <div class="information-text">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        @endif

        <div class="edit-profile">
            <form class="form-grid" method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="h3">Редактировать профиль</div>

                <div class="f-wrap f-full">
                    <input placeholder="text" type="email" name="email" value="{{  $user->email }}" readonly disabled>
                    <div class="f-placeholder">Email</div>
                    @svg('images/svg/email.svg')
                </div>
                <div class="f-wrap f-full">
                    <input placeholder="text" type="text" name="name"  value="{{ old('name', $user->name) }}" required>
                    <div class="f-placeholder">Имя</div>
                    @svg('images/svg/user.svg')
                </div>
                <div class="f-wrap f-full">
                    <input class="format-phone" placeholder="text" type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                    <div class="f-placeholder">Телефон</div>
                    @svg('images/svg/phone.svg')
                </div>

                <button class="btn">Сохранить</button>
            </form>
        </div>

        <div class="edit-profile">
            <form class="form-grid" method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="h3">Редактировать пароль</div>

                <div class="f-wrap f-full">
                    <input placeholder="text" type="password" name="current_password" required>
                    <div class="f-placeholder">Старый пароль</div>
                    @svg('images/svg/lock.svg')
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

                <button class="btn">Изменить</button>
            </form>
        </div>

    </div>
</div>

@endsection
