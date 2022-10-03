@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('head_end')
	<meta name="robots" content="noindex, nofollow"/>
@endsection

@section('content')

<div class="distributors-box">
	<div class="container">
		<div class="order-form go-distrib">
			<div class="top-row">
				<h1 class="h2 h2-title">{{ $page['title'] }}</h1>
				{!! $page['description'] !!}
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

