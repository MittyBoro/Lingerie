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
        @vite('resources/front/js/app.js')


        {{-- <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css', 'assets') }}"> --}}

        @yield('head_end')
        {{-- {!! $props['head_code'] ?? '' !!} --}}

    </head>
    <body class="preload page-{{ $view_name }}">
        {{-- @auth
            @includeWhen(Auth::user()->is_editor, 'elements.admin_row')
        @endauth --}}

        <div class="wrapper">
            <div class="header-box">
                <div class="container">
                    <div class="col-menu left-menu">
                        <div class="m-item"><a href="#">Каталог</a></div>
                        <div class="m-item">
                            <a href="#">
                                <span>Категории</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </a>
                            <div class="m-item-list">
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                            </div>
                        </div>
                        <div class="m-item"><a href="#">Доставка</a></div>
                    </div>
                    <a href="/" class="logo">
                       @svg('images/icons/logo.svg')
                    </a>
                    <div class="col-menu right-menu">
                        <div class="m-item"><a href="#">FAQ</a></div>
                        <div class="m-item"><a href="#">Корзина (<span>0</span>)</a></div>
                        <div class="m-item">
                            <a href="#">
                                <span>Русский</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </a>
                            <div class="m-item-list">
                                <a href="#">Русский</a>
                                <a href="#">English</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @yield('content')


            <div class="footer-box">
                <div class="container">
                    <div class="top-row grid-12">
                        <div class="top-col">
                            <div class="f-title mini-title">Нижнее белье</div>
                            <ul>
                                <li><a href="#">Бюстгальтеры</a></li>
                                <li><a href="#">Трусики</a></li>
                                <li><a href="#">Пояса</a></li>
                                <li><a href="#">Комплекты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title mini-title">для дома</div>
                            <ul>
                                <li><a href="#">Пижамы</a></li>
                                <li><a href="#">Халаты</a></li>
                            </ul>
                        </div>
                        <div class="top-col tar">
                            <div class="f-title mini-title">Купальники</div>
                            <ul>
                                <li><a href="#">Слитные</a></li>
                                <li><a href="#">Раздельные</a></li>
                            </ul>
                        </div>
                        <div class="top-col tar">
                            <div class="f-title mini-title primary">Клиентам</div>
                            <ul>
                                <li><a href="#">Доставка</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-row">
                        <div>
                            <a href="#" class="politic-link">Политика конфиденциальности</a>
                        </div>
                        <div>
                            <a href="#" class="insta">
                                @svg('images/icons/instagram.svg')
                                <span>Наш Instagram</span>
                            </a>
                        </div>
                        <p>Legendary Lingerie © 2022</p>
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
