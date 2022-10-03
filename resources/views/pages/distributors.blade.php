@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="distributors-box">
	<div class="container" id="partners">

		<div class="breadcrumb">
			<a href="/">Главная</a> /
			<span>{{ $page['title'] }}</span>
		</div>

		<h1 class="h2 h2-title">{{ $page['title'] }}</h1>

		<div class="form-box">
			<div class="left-text">
				{!! $page['description'] !!}
			</div>
			<div class="right-form">
				<div class="f-wrap">
					<input placeholder="text" v-model="city" type="text">
					<div class="f-placeholder">Введите ваш город</div>
					<div class="btn">
						@svg('images/svg/search.svg')
					</div>
				</div>
			</div>
		</div>
		<div class="distributors-grid">
			@foreach ($partners as $item)
				<div class="ds-item" :class="{ invisible: !showCity('{{ $item->city }}') }">
					<div class="ds-avatar flex-center">
						@if ($item->avatar)
							<img src="{{ $item->avatar }}" alt="">
						@else
							<div class="ds-letter">{{ $item->first_letters }}</div>
						@endif
					</div>
					<div class="right-col">
						<div class="h3">{{ $item->person_name }}</div>
						<a href="{{ route('front.pages', ['city-shop', $item->slug_city]) }}" class="ds-city">
							<span v-if="!city">{{ $item->city }}</span>
							<span v-else v-html="highlight('{{ $item->city }}')"></span>
						</a>
						@includeWhen($item->information, 'elements.partner_icons', ['information' => $item->information])
					</div>
				</div>
			@endforeach
			<div class="list-empty h2">
				Ничего не найдено :(
			</div>
		</div>
	</div>

	<div class="container">
		<div class="order-form go-distrib">
			<div class="top-row">
				<h2 class="h2 h2-title">Стать дистрибьютором</h2>
				<p>Оставьте заявку если хотите стать частью семьи AleVi</p>
			</div>
			<form @submit.prevent="submit" class="form-distributors form-row">
				<input type="hidden" :value="form.form = 'distributor'">
				<div class="f-wrap">
					<input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
					<div class="f-placeholder">Ваше имя</div>
					@svg('images/svg/user.svg')
				</div>
				<div class="space"></div>
				<div class="f-wrap">
					<input placeholder="text" type="text" autocomplete="tel" v-model="form.phone" required>
					<div class="f-placeholder">Ваш телефон</div>
					@svg('images/svg/phone.svg')
				</div>
				<div class="space"></div>
				<div class="f-wrap">
					<input placeholder="text" type="text" autocomplete="address-level2" v-model="form.city" required>
					<div class="f-placeholder">Ваш город</div>
					@svg('images/svg/location.svg')
				</div>
				<div class="space"></div>
				<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
					<span :class="{ hidden: success }">Оставить заявку</span>
					<span :class="{ hidden: !success }">Заявка принята</span>
				</button>
			</form>
		</div>
	</div>
</div>


@endsection

@section('body_end')

	<style>
		.distributors-grid a.ds-city {
			display: inline-block;
			border-bottom: 1px solid #999;
			margin-bottom: 10px;
		}
		.distributors-grid a.ds-city:hover {
			border-color: #C790E7;
		}
	</style>

@endsection
