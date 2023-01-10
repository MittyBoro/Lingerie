<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">

        <title>@yield('meta_title', 'Lingerie')</title>

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

        @vite('resources/front/sass/style.sass')


        {{-- <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css', 'assets') }}"> --}}

        @yield('head_end')
        {{-- {!! $props['head_code'] ?? '' !!} --}}

    </head>
    {{-- !!! preloadd --}}
    <body class="preloaddd page-{{ $view_name }}">
        {{-- @auth
            @includeWhen(Auth::user()->is_editor, 'elements.admin_row')
        @endauth --}}

        <div class="wrapper">
            <div class="header-box">
                <div class="container">
                    <div class="col-menu left-menu">
                        <div class="m-item"><a href="#">Каталог</a></div>
                        <div class="m-item"><a href="#">
                            <span>Категории</span>
                            <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon-arrow">
                        </a></div>
                        <div class="m-item"><a href="#">Доставка</a></div>
                    </div>
                    <a href="/" class="logo">
                       @svg('images/icons/logo.svg')
                    </a>
                    <div class="col-menu right-menu">
                        <div class="m-item"><a href="#">FAQ</a></div>
                        <div class="m-item"><a href="#">Корзина (<span>0</span>)</a></div>
                        <div class="m-item"><a href="#">
                            <span>Русский</span>
                            <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon-arrow">
                        </a></div>
                    </div>
                </div>
            </div>


            @yield('content')


            <div class="footer-box">
                <div class="container">
                    <div class="top-row">
                        <div class="top-col">
                            <div class="f-title">Нижнее белье</div>
                            <ul>
                                <li><a href="#">Бюстгальтеры</a></li>
                                <li><a href="#">Трусики</a></li>
                                <li><a href="#">Пояса</a></li>
                                <li><a href="#">Комплекты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title">для дома</div>
                            <ul>
                                <li><a href="#">Пижамы</a></li>
                                <li><a href="#">Халаты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title">Купальники</div>
                            <ul>
                                <li><a href="#">Слитные</a></li>
                                <li><a href="#">Раздельные</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title">КЛИЕНТам</div>
                            <ul>
                                <li><a href="#">Доставка</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-row">
                        <a href="#">Политика конфиденциальности</a>
                        <a href="#" class="insta">
                            @svg('images/icons/instagram.svg')
                            <span>Наш Instagram</span>
                        </a>
                        <span>Legendary Lingerie © 2022</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- <script>
            const config = { mainAddress: @json( $props['map_addresses'] ), };
            const cartCount = @json( $cart_count ?? null );
        </script> --}}

        {{-- <script src="{{ mix('js/app.js', 'assets') }}" defer></script> --}}

        @yield('body_end')

        {{-- {!! $props['body_code'] ?? '' !!} --}}
    </body>
</html>
