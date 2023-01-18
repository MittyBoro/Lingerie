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


        <style>
            .preload-box {
                position: fixed;
                top: 0;
                right: 0;
                left: 0;
                bottom: 0;
                background: #FFF2F0;
                z-index: 999;

                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                color: #DEA19A;
            }
            .preload-box .loading-logo {
                max-width: 90%;
                animation: blink 1s infinite linear alternate;
            }
            .preload-box .loading-logo svg {
                width: 300px;
                height: auto;
            }
            .preload-box .loading-circle {
                margin: 30px 0;
                width: 40px;
                height: 40px;
                border: 1px solid #CACC9C;
                border-left-width: 3px;
                border-right-width: 3px;
                animation: round 1s infinite linear;
                border-radius: 50%;
            }
            .preload-box .loading-text {
                color: #858585;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                font-size: 16px;
            }
        </style>


        {{-- <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css', 'assets') }}"> --}}

        @yield('head_end')
        {{-- {!! $props['head_code'] ?? '' !!} --}}

    </head>
    <body class="preload page-{{ $view_name }} @yield('body_class')">

        <div class="preload-box">
            <div class="loading-logo">
                @svg('images/icons/logo.svg')
            </div>
            <div class="loading-circle"></div>
            <div class="loading-text">@lang('front.loading')...</div>
        </div>
        {{-- @auth
            @includeWhen(Auth::user()->is_editor, 'elements.admin_row')
        @endauth --}}

        <div class="wrapper">
            <div class="header-box" toggling>
                <div class="container">
                    <div class="hamb-wrap">
                        <div class="hamburger" toggle-click></div>
                    </div>
                    <div class="col-menu left-menu">
                        <div class="m-item"><a href="#">@lang('front.catalog')</a></div>
                        <div class="m-item">
                            <span class="a">
                                <span>@lang('front.categories')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <div class="m-item-list">
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                                <a href="#">Категория</a>
                            </div>
                        </div>
                        <div class="m-item"><a href="#">@lang('front.delivery')</a></div>
                    </div>
                    <a href="/" class="logo">
                       @svg('images/icons/logo.svg')
                    </a>
                    <div class="col-menu right-menu">
                        <div class="m-item"><a href="#">FAQ</a></div>
                        <div class="m-item"><a href="#">@lang('front.cart') (<span>0</span>)</a></div>
                        <div class="m-item">
                            <span class="a">
                                <span>@lang('front.current_lang')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <div class="m-item-list">
                                <a href="/locale/ru">Русский</a>
                                <a href="/locale/en">English</a>
                            </div>
                        </div>
                    </div>
                    <div class="cart-wrap">
                        <div class="cart-icon a">
                            <span class="int">3</span>
                            @svg('images/icons/shopping-bag.svg')
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-box">
                <div class="container">
                    <div class="grid-row grid-2">
                        <div class="top-col">
                            <div class="f-title mini-title secondary">@lang('front.footer.lingerie')</div>
                            <ul>
                                <li><a href="#">Бюстгальтеры</a></li>
                                <li><a href="#">Трусики</a></li>
                                <li><a href="#">Пояса</a></li>
                                <li><a href="#">Комплекты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title mini-title secondary">@lang('front.footer.swimwear')</div>
                            <ul>
                                <li><a href="#">Слитные</a></li>
                                <li><a href="#">Раздельные</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title mini-title secondary">@lang('front.footer.for_house')</div>
                            <ul>
                                <li><a href="#">Пижамы</a></li>
                                <li><a href="#">Халаты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title mini-title primary">@lang('front.footer.for_lients')</div>
                            <ul>
                                <li><a href="#">Доставка</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-row">
                        <div class="gray">
                            <a href="#" class="insta">
                                @svg('images/icons/instagram.svg')
                                <span>@lang('front.our_instagram')</span>
                            </a>
                        </div>
                        <div class="m-item">
                            <span class="a tar prevent">
                                <span>@lang('front.current_lang')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <div class="m-item-list">
                                <a href="/locale/ru">Русский</a>
                                <a href="/locale/en">English</a>
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
                            <div class="f-title mini-title">@lang('front.footer.lingerie')</div>
                            <ul>
                                <li><a href="#">Бюстгальтеры</a></li>
                                <li><a href="#">Трусики</a></li>
                                <li><a href="#">Пояса</a></li>
                                <li><a href="#">Комплекты</a></li>
                            </ul>
                        </div>
                        <div class="top-col">
                            <div class="f-title mini-title">@lang('front.footer.for_house')</div>
                            <ul>
                                <li><a href="#">Пижамы</a></li>
                                <li><a href="#">Халаты</a></li>
                            </ul>
                        </div>
                        <div class="top-col tar">
                            <div class="f-title mini-title">@lang('front.footer.swimwear')</div>
                            <ul>
                                <li><a href="#">Слитные</a></li>
                                <li><a href="#">Раздельные</a></li>
                            </ul>
                        </div>
                        <div class="top-col tar">
                            <div class="f-title mini-title primary">@lang('front.footer.for_clients')</div>
                            <ul>
                                <li><a href="#">Доставка</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-row">
                        <div class="politic-col">
                            <a href="#" class="politic-link">@lang('front.footer.policy')</a>
                        </div>
                        <div class="insta-col">
                            <a href="#" class="insta">
                                @svg('images/icons/instagram.svg')
                                <span>@lang('front.our_instagram')</span>
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

        <div class="bottom-box" style="display: grid; text-align: center; gap: 2px; padding: 30px">
            <a href="http://lingerie.bo/">home</a>
            <a href="http://lingerie.bo/catalog">catalog</a>
            <a href="http://lingerie.bo/product">product</a>
            <a href="http://lingerie.bo/cart">cart</a>
            <a href="http://lingerie.bo/order">order</a>
            <a href="http://lingerie.bo/page">page</a>
            <a href="http://lingerie.bo/faq">faq</a>
            <a href="http://lingerie.bo/success">success</a>
            <a href="http://lingerie.bo/404">404</a>
        </div>

    </body>
</html>
