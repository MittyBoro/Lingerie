@extends('layouts.main')

@section('meta_title', 'Личный кабинет | ' . config('app.name'))

@section('content')

<div class="profile-box profile-grid">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>Личный кабинет</span>
        </div>

        <div class="profile-grid-item">
            <div class="profile-wrap">
                <div class="top-row">
                    <div class="h3">Личные данные</div>
                    <a href="{{ route('profile.edit') }}" class="btn-nano">Изменить</a>
                </div>

                <div class="info-col">
                    <p class="i-name">{{ $user->name }}</p>
                    <p>{{ $user->email }}</p>
                    <p>{{ $user->phone ?? 'Телефон не указан' }}</p>
                </div>
            </div>
            <div class="profile-wrap pw-bonuses">
                <div class="top-row">
                    <div class="h3">У вас <span>{{ format_price($user->bonuses) }}</span> {{ sklonenie($user->bonuses, ['бонусный рубль', 'бонусных рубля', 'бонусных рублей']) }}</div>
                    <a href="{{ route('profile.bonuses') }}" class="btn-nano">История</a>
                </div>
            </div>
        </div>

        <div class="profile-wrap" id="orders">
            @if($orders->isNotEmpty())
                <div class="top-row">
                    <div class="h3">Ваши заказы</div>
                </div>

                <div class="orders-list">
                    @each('elements.order_info', $orders, 'order')
                    @if($orders->count() > 5)
                        <div class="btn-wrap">
                            <div class="btn btn-nano show-more-orders">
                                <span class="text-show">Посмотреть все</span>
                                <span class="text-hide">Скрыть</span>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="tac">
                    <div class="h3" style="margin-bottom: 20px;">Вы ещё ничего не купили</div>
                    <a href="/shop" class="btn btn-mini">В каталог</a>
                </div>
            @endif

        </div>

    </div>
</div>

@endsection


@section('body_end')

<script>

    document.addEventListener('DOMContentLoaded', function() {

        let showMoreBtn = document.querySelector('.show-more-orders');

        if (!showMoreBtn)
            return;

        showMoreBtn.addEventListener('click', function() {
            document.querySelector('.orders-list').classList.toggle('active');
        });

    });

</script>

@endsection
