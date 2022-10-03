@extends('layouts.main')

@section('meta_title', 'Личный кабинет | ' . config('app.name'))

@section('content')

<div class="profile-box">
	<div class="container">

		<div class="breadcrumb">
			<a href="/">Главная</a> /
			<a href="/profile">Личный кабинет</a> /
			<span>Бонусы</span>
		</div>

		<div class="profile-wrap">
			@if($bonuses->isNotEmpty())
				<div class="top-row">
					<div class="h3">У вас <span class="color">{{ format_price($user->bonuses) }}</span> {{ sklonenie($user->bonuses, ['бонусный рубль', 'бонусных рубля', 'бонусных рублей']) }}</div>
				</div>

				<div class="bonus-list">
					@foreach ($bonuses as $bonus)
						<a @if ($bonus->order_id) href="{{ route('profile.order', $bonus->order_id) }}" @endif class="bonus-row">
							<div class="bonus-name">
								<span>
									<b>{{ $bonus->title }}</b>
									<i>от <span data-format-date="{{ $bonus->created_at }}">{{ format_date($bonus->created_at) }}</span></i>
								</span>
								@if($bonus->end_at)
									<span class="bonus-date">до <span data-format-date="{{ $bonus->end_at }}">{{ format_date($bonus->end_at) }}</span>
								@endif
							</div>
							<div class="bonus-amount">
								<span>{{ format_price($bonus->amount, true) }}₽</span>
							</div>
						</a>
					@endforeach
				</div>
			@else
				<div class="tac">
					<div class="h3" style="margin-bottom: 20px;">Вам ещё ничего не начислено</div>
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
