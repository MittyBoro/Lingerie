<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

		<title>@yield('meta_title', 'AleVi')</title>

		<meta name="description" content="@yield('meta_description', '')">
		<meta name="keywords" content="@yield('meta_keywords', '')" />

		<meta property="og:locale" content="ru_RU" />
		<meta property="og:title" content="@yield('meta_title', '')">
		<meta property="og:description" content="@yield('meta_description', '')">
		<meta property="og:type" content="@yield('meta_type', 'website')">
		@hasSection('meta_image')
			<meta property="og:image" content="@yield('meta_image')" />
		@endif

		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,500;1,300&family=Playfair+Display&display=swap" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="{{ mix('css/style.css', 'assets') }}">

		@yield('head_end')
		{!! $props['head_code'] ?? '' !!}

	</head>
	<body class="preload page-{{ $view_name }}">
		@auth
			@includeWhen(Auth::user()->is_editor, 'elements.admin_row')
		@endauth

		<div class="wrapper">

			<div class="header">
				<div class="container">
					<div class="top-row">
						<div class="hamburger"><span></span></div>

						<a class="logo" href="/">
							@svg('images/svg/logo.svg')
						</a>

						<form action="/search" class="head_search">
							<button class="btn">
								@svg('images/svg/search.svg')
							</button>
							<input placeholder="Поиск..." minlength="3" type="text" name="q">
						</form>

						<div class="cont-col">
							<a class="cont-phone" href="tel:{{ clear_phone($props['phone']) }}">
								@svg('images/svg/phone_round.svg')
								<span>{{ $props['phone'] }}</span>
							</a>
							<div class="cont-time">Пн-Чт 9:00-18:00    Пт 9:00-17:00</div>
						</div>

						@auth
							<div class="person">
								<div class="p-ava"></div>
								<div class="p-name p-name-mini">{{ auth()->user()->first_name }}</div>
								<div class="person-box">
									<div class="p-name-row">
										<div class="p-ava"></div>
										<div class="p-name">{{ auth()->user()->name }}</div>
									</div>

									<div class="links">
										<a href="{{ route('profile.bonuses') }}">У вас {{ format_price(auth()->user()->bonuses) }} {{ sklonenie(auth()->user()->bonuses, ['бонус', 'бонуса', 'бонусов']) }}</a>
										<a href="{{ route('profile.show') }}">Личный кабинет</a>
										<a href="{{ route('profile.show') }}#orders">История заказов</a>

										<form method="POST" action="{{ route('logout') }}" class="logout">
											@csrf
											<button>
												@svg('images/svg/logout.svg')
												<span>Выход</span>
											</button>
										</form>
									</div>
								</div>
							</div>
						@else
							<div class="sign-btns">
								<a href="/login" class="btn btn-white">Вход</a>
								<a href="/register" class="btn btn">Регистрация</a>
							</div>
						@endauth
						<a id="head_cart" href="/cart" class="head_cart">
							@svg('images/svg/new_cart.svg')
							<span v-text="count"></span>
						</a>
					</div>

					<div class="bottom-row">
						{{-- <div class="hamburger"><span></span></div> --}}
						<ul class="ul-menu">
							<li><a href="/shop">Каталог</a></li>
							<li><a href="/distributors">Дистрибьюторы</a></li>
							<li><a href="/franchisee">Франчайзи</a></li>
							<li><a href="/contract">Контрактное производство</a></li>
							<li><a href="/franchising">Франчайзинг</a></li>
							<li><a href="/news">Блог</a></li>
							<li><a href="/about">О нас</a></li>
							<li><a href="/contacts">Контакты</a></li>
						</ul>
					</div>

					<div class="big-menu-box">
						<ul class="ul-menu">
							<li><a href="/shop">Каталог</a></li>
							<li><a href="/distributors">Дистрибьюторы</a></li>
							<li><a href="/franchisee">Франчайзи</a></li>
							<li><a href="/contract">Контрактное производство</a></li>
							<li><a href="/franchising">Франчайзинг</a></li>
							<li><a href="/news">Блог</a></li>
							<li><a href="/about">О нас</a></li>
							<li><a href="/contacts">Контакты</a></li>
						</ul>

						<form action="/search" class="head_search">
							<button class="btn">
								@svg('images/svg/search.svg')
							</button>
							<input placeholder="Поиск..." minlength="3" type="text" name="q">
						</form>

						<div class="cont-col">
							<a class="cont-phone" href="tel:{{ clear_phone($props['phone']) }}">
								@svg('images/svg/phone_round.svg')
								<span>{{ $props['phone'] }}</span>
							</a>
							<div class="cont-time">Пн-Чт 9:00-18:00    Пт 9:00-17:00</div>
						</div>
					</div>
				</div>
			</div>


			@yield('content')


			<div class="footer">
				<div class="container">
					<div class="footer-content order-form col-xl-10 col-lg-11">
						<div class="f-column">
							<div class="f-title">Каталог</div>
							<ul>
								<li><a href="/category/shugars">Пасты</a></li>
								<li><a href="/category/cosmetics">Косметика</a></li>
								<li><a href="/category/scrubs">Скрабы</a></li>
							</ul>
						</div>
						<div class="f-column">
							<div class="f-title">Cотрудничество</div>
							<ul>
								<li><a href="/franchising">Франчайзинг</a></li>
								<li><a href="/contract">Контрактное<br>производство</a></li>
							</ul>
						</div>
						<div class="f-column">
							<div class="f-title">Партнеры</div>
							<ul>
								<li><a href="/distributors">Дистрибьюторы</a></li>
								<li><a href="/franchisee">Франчайзи</a></li>
							</ul>
						</div>
						<div class="f-column">
							<div class="f-title">AleVi</div>
							<ul>
								<li><a href="/about">О нас</a></li>
								<li><a href="/news">Блог</a></li>
								<li><a href="/contacts">Контакты</a></li>
							</ul>
						</div>
						<form @submit.prevent="submit" class="f-column f-col-form">
							<input type="hidden" :value="form.form = 'news_footer'">
							<div class="f-title">Будьте в курсе наших новостей</div>
							<div class="f-wrap">
								<input placeholder="text" type="email" autocomplete="email" v-model="form.email" required>
								<div class="f-placeholder">Ваша почта</div>
								<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
									<span :class="{ hidden: success }">@svg('images/svg/arrow.svg')</span>
									<span :class="{ hidden: !success }">@svg('images/svg/check.svg')</span>
								</button>
							</div>
						</form>
						<div class="f-column f-icons">
							<a target="_blank" href="{{ $props['vk'] }}">
								@svg('images/svg/vk.svg')
							</a>
							{{-- <a target="_blank" href="{{ $props['instagram'] }}">
								@svg('images/svg/instagram.svg')
							</a> --}}
							<a target="_blank" href="{{ $props['vk_group'] }}">
								@svg('images/svg/vk.svg')
							</a>
						</div>
					</div>
					<div class="footer-bottom">
						<a class="logo" href="/">
							@svg('images/svg/logo.svg')
						</a>
						<a href="/privacy-policy" class="policy">Политика конфиденциальности</a>
						<div class="footer-copy">© 2016 — {{ date('Y') }}</div>
					</div>
				</div>
			</div>

			<!-- to top -->
			<div class="arrow-top"></div>

		</div>

		<script>
			const config = { mainAddress: @json( $props['map_addresses'] ), };
			const cartCount = @json( $cart_count ?? null );
		</script>

        <script src="{{ mix('js/app.js', 'assets') }}" defer></script>
		@include('elements.popups')

		@yield('body_end')

		{!! $props['body_code'] ?? '' !!}
	</body>
</html>
