@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="home-screen">
	<div class="container">

		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<div class="screen screen-1">
						<div class="left-wrap">
							<h2 class="title h1">Станьте дистрибьютором
								косметики AleVi и продавайте
								нашу продукцию в своем городе</h2>
							<a href="/become-distributor" class="btn">Оставить заявку</a>
						</div>
						<div class="right-wrap">
							<img src="{{ asset('images/slide-1.png') }}" alt="">
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="screen screen-2">
						<div class="left-wrap">
							<h2 class="title h1">Откройте бизнес в сфере
								депиляции по франшизе AleVi
								с доходом от 150 000 в месяц</h2>
							<a href="/franchising" class="btn">Узнать больше</a>
						</div>
						<div class="right-wrap">
							<img src="{{ asset('images/slide-2.png') }}" alt="">
						</div>
					</div>
				</div>
				<div class="swiper-slide">
					<div class="screen screen-3">
						<div class="left-wrap">
							<h2 class="title h1">Возьмем на себя полный цикл
								производства косметики
								специально для вашего бренда</h2>
							<a href="/contract" class="btn">Узнать больше</a>
						</div>
						<div class="right-wrap">
							<img src="{{ asset('images/slide-3.png') }}" alt="">
						</div>
					</div>
				</div>
			</div>
			<div class="swiper-navigation">
				<div class="swiper-numeric"></div>
				<div class="swiper-nav-bottom">
					<div class="swiper-button swiper-button-prev">
						@svg('images/svg/arrow.svg')
					</div>
					<div class="swiper-pagination"></div>
					<div class="swiper-button swiper-button-next">
						@svg('images/svg/arrow.svg')
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<div class="home-about">
	<div class="container">
		<div class="left-text">
			<h2 class="h2 h2-title">{{ $page->props['about_title'] }}</h2>
			<p>{!! nl2br($page->props['about_text_1']) !!}</p>
		</div>
		<div class="middle-box">
			<img class="img-1" width="300" src="{{ $page->props['about_photo_1'] }}" alt="">
			<img class="img-2" width="370" src="{{ $page->props['about_photo_2'] }}" alt="">
			<img class="img-mobi" src="{{ $page->props['about_photo_mobi'] }}" alt="">
			<div class="people-info">
				<div class="a-name">Анна Михайлова</div>
				<div class="a-post">Основатель ТМ AleVi</div>
				{{-- <div class="a-name">Алексей Михайлов</div>
				<div class="a-post">Директор производства</div> --}}
			</div>
		</div>
		<div class="right-text">
			<p>{!! nl2br($page->props['about_text_2']) !!}</p>
			<a href="/about" class="btn">Узнать больше</a>
		</div>
	</div>
</div>

<div class="home-categories">
	<div class="container">
		<div class="left-text">
			<h2 class="h2 h2-title">Категории товаров</h2>
			<p>{!! nl2br($page->props['category_text']) !!}</p>
		</div>
		<div class="my-little-grid">
			<a href="/category/shugars" class="element el-left">
				<h3 class="h3">Пасты для шугаринга</h3>
				<img width="236" src="{{ asset('images/cat-pasta.png') }}" alt="">
			</a>
			<div class="middle-col">
				<a href="/category/cosmetics" class="element el-top">
					<img width="287" src="{{ asset('images/cat-cos.png') }}" alt="">
					<h3 class="h3">Косметика</h3>
				</a>
				<a href="/category/scrubs" class="element el-bottom">
					<h3 class="h3">Скрабы</h3>
					<img width="208" src="{{ asset('images/cat-scr.png') }}" alt="">
				</a>
			</div>
			<a href="/shop" class="element el-right">
				<h3 class="h3">Перейти в каталог</h3>
			</a>
		</div>
		<a href="/shop" class="btn btn-mini">Перейти в каталог</a>
	</div>
</div>

<div class="home-catalog">
	<div class="container">
		<h2 class="h2 h2-title">Наши новинки</h2>
		@include('elements.four_products', ['products' => $products])
	</div>
</div>

<div class="home-distributor">
	<div class="container">
		<h2 class="h2 h2-title">Найти дистрибьютора в своем городе</h2>

		<div class="form-box col-xl-11">
			<div class="left-text">
				{!! nl2br($page->props['distrib_text']) !!}
			</div>
			<form action="/distributors" method="get" class="right-form">
				<div class="f-wrap">
					<input placeholder="text" name="city" type="text">
					<div class="f-placeholder">Введите ваш город</div>
					<button class="btn">
						@svg('images/svg/search.svg')
					</button>
				</div>
			</form>
		</div>

	</div>
</div>

<div class="home-cooperate">
	<div class="container">
		<h2 class="h2 h2-title">Давайте сотрудничать</h2>

		<div class="left-text col-xl-9 col-lg-11">
			{{ $page->props['cooperate_text'] }}
		</div>

		<div class="cooper-row">
			<a href="/franchising" class="cooper-box cooper-left">
				<span class="h3">Франчайзинг</span>
				<img src="{{ asset('images/slide-2.png') }}" alt="">
			</a>
			<a href="/contract" class="cooper-box cooper-right">
				<span class="h3">Контрактное<br>производство</span>
				<img src="{{ asset('images/slide-3.png') }}" alt="">
			</a>
		</div>

		<div class="tink-info">
			<div class="h2">А также мы предлагаем открыть бизнес <span class="color">в рассрочку</span></div>
			<a rel="nofollow" href="https://www.tinkoff.ru/business/turnover/?dco_ic=e227273f-fc4a-11ec-8000-0000308e68af&utm_source=partner_rko_a_sme&agentId=5-EPZ2Y2J3&partnerId=5-EPZ2Y2HU&agentSsoId=97850818-bd2d-42fd-bbc5-3b35b47121d6&utm_campaign=sme.partners&utm_medium=ptr.act" target="_blank" class="btn btn-yellow">Оставить заявку</a>
		</div>
	</div>
</div>

<div class="blog-subscribe order-form">
	<div class="container">
		<div class="top-row">
			<h2 class="h2 h2-title">Блог AleVi</h2>
			<p>Подпишитесь на рассылку, чтобы быть в курсе наших последних событий и новостей.</p>
		</div>

		<form @submit.prevent="submit" class="form-subscribe form-row col-xl-10">
			<input type="hidden" :value="form.form = 'blog_subscribe'">
			<div class="f-wrap">
				<input placeholder="text" type="text" autocomplete="email" v-model="form.email" required>
				<div class="f-placeholder">Ваша почта</div>
			</div>
			<div class="space"></div>
			<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
				<span :class="{ hidden: success }">Подписаться</span>
				<span :class="{ hidden: !success }">Готово</span>
			</button>
			<div class="space"></div>
			<label class="agreement">
				<input type="checkbox" required checked>
				<span>Я даю согласие на обработку<br>персональных данных</span>
			</label>
		</form>

	</div>
</div>

<div class="home-news">
	<div class="container">
		<div class="news-list">
			@foreach ($news as $article)
				@include('elements.post_item')
			@endforeach
		</div>

		<div class="btn-wrap">
			<a href="/news" class="btn btn-mini">Перейти в блог</a>

			<div class="f-icons">
				<a target="_blank" href="{{ $props['vk'] }}">
					@svg('images/svg/vk.svg')
				</a>
				<a target="_blank" href="{{ $props['instagram'] }}">
					@svg('images/svg/instagram.svg')
				</a>
				<a target="_blank" href="{{ $props['vk_group'] }}">
					@svg('images/svg/vk.svg')
				</a>
			</div>
		</div>
	</div>
</div>

<div class="home-contact">
	<div class="container">
		<div class="top-row">
			<h2 class="h2 col-lg-4">Связаться с нами</h2>
			<p>Есть вопросы? Оставьте заявку, чтобы мы могли<br>с вами связаться и ответить на них.</p>
		</div>

		<div class="order-form contact-box flex fww">
			<div class="contact-left col-lg-4 col-md-5">
				<p>По вопросам заказа продукции<br>
					и сотрудничества:</p>

				<a class="cont-item" href="tel:{{ $props['phone'] }}">
					@svg('images/svg/phone_round.svg')
					<span>{{ $props['phone'] }}</span>
				</a>
				<a class="cont-item" href="{{ $props['vk'] }}">
					@svg('images/svg/vk.svg')
					<span>Анна Михайлова</span>
				</a>
				<a class="cont-item" href="{{ $props['vk_group'] }}">
					@svg('images/svg/vk.svg')
					<span>Группа ВКонтакте</span>
				</a>
				<span class="cont-item">
					@svg('images/svg/location.svg')
					<span>{{ $props['address'] }}</span>
				</span>
			</div>

			<form @submit.prevent="submit" class="contact-right col-md-7">
				<div class="subtitle">Или оставьте заявку и мы сами свяжемся с вами:</div>
				<input type="hidden" :value="form.form = 'contact_us'">
				<div class="f-wrap">
					<input placeholder="text" type="text" autocomplete="name" v-model="form.name" required>
					<div class="f-placeholder">Ваше имя</div>
					@svg('images/svg/user.svg')
				</div>
				<div class="f-wrap">
					<input placeholder="text" type="text" autocomplete="tel" v-model="form.phone" required>
					<div class="f-placeholder">Ваш телефон</div>
					@svg('images/svg/phone.svg')
				</div>
				<div class="f-wrap f-big">
					<textarea placeholder="text" v-model="form.comment"></textarea>
					<div class="f-placeholder">Ваш вопрос</div>
					@svg('images/svg/pen.svg')
				</div>
				<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
					<span :class="{ hidden: success }">Оставить заявку</span>
					<span :class="{ hidden: !success }">Заявка принята</span>
				</button>
				<label class="agreement">
					<input type="checkbox" required checked>
					<span>Я даю согласие на обработку<br>персональных данных</span>
				</label>
			</form>
		</div>
	</div>
</div>

<div class="home-map">
	<div class="container">
		<div id="map"></div>
	</div>
</div>

@endsection
