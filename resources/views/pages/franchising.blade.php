@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="franchising-box">
	<div class="container">

		<div class="breadcrumb">
			<a href="/">Главная</a> /
			<span>{{ $page['title'] }}</span>
		</div>

		<h1 class="h2 h2-title">{{ $page['title'] }}</h1>

		<div class="franchising-text formatted-text">
			{!! $page['description'] !!}
		</div>

		<div class="order-form go-contract">
			<form @submit.prevent="submit" class="form-row col-lg-9 mr-auto">
				<input type="hidden" :value="form.form = 'franchising'">
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
				<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
					<span :class="{ hidden: success }">Оставить заявку</span>
					<span :class="{ hidden: !success }">Заявка принята</span>
				</button>
			</form>
		</div>

		<div class="tink-info">
			<div class="h2">А также мы предлагаем открыть бизнес <span class="color">в рассрочку</span></div>
			<a rel="nofollow" href="https://www.tinkoff.ru/business/turnover/?dco_ic=e227273f-fc4a-11ec-8000-0000308e68af&utm_source=partner_rko_a_sme&agentId=5-EPZ2Y2J3&partnerId=5-EPZ2Y2HU&agentSsoId=97850818-bd2d-42fd-bbc5-3b35b47121d6&utm_campaign=sme.partners&utm_medium=ptr.act" target="_blank" class="btn btn-yellow">Оставить заявку</a>
		</div>

	</div>
</div>

@endsection
