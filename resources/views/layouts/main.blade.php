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
            }
            .preload-box .loading-logo {
                max-width: 90%;
                animation: blink 1s infinite linear alternate;
                color: #DEA19A;
            }
            .preload-box .loading-logo svg {
                width: 300px;
                height: auto;
            }
            .preload-box .loading-circle {
                flex-shrink: 0;
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

        @yield('headcode')
        {{-- {!! $props['head_code'] ?? '' !!} --}}

    </head>
    <body class="preload page-{{ $viewName }} @yield('body_class')">

        <div class="preload-box">
            <a href="/" class="loading-logo">
                @svg('images/icons/logo.svg')
            </a>
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

                        <div class="m-item"><a href="/catalog">@lang('front.catalog')</a></div>
                        <div class="m-item">
                            <span class="a">
                                <span>@lang('front.categories')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <div class="m-item-list">
                                @foreach ($categories as $cat)
                                    <a href="{{ route('front.categories', $cat['slug']) }}">{{ $cat['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="m-item"><a href="/delivery">@lang('front.delivery')</a></div>
                    </div>
                    <a href="/" class="logo">
                       @svg('images/icons/logo.svg')
                    </a>
                    <div class="col-menu right-menu">
                        <div class="m-item"><a href="/faq">FAQ</a></div>
                        <div class="m-item"><a href="/cart">@lang('front.cart') (<span class="cart-count">{{ $cartCount }}</span>)</a></div>
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
                            <span class="int cart-count">{{ $cartCount }}</span>
                            @svg('images/icons/shopping-bag.svg')
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-box">
                <div class="container">
                    <div class="grid-row grid-2">

                       @include('elements.footer_category')

                        <div class="top-col">
                            <div class="f-title mini-title primary">@lang('front.for_clients')</div>
                            <ul>
                                <li><a href="/delivery">{{ $pages['delivery'] ?? '' }}</a></li>
                                <li><a href="/faq">{{ $pages['faq'] ?? '' }}</a></li>
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
                        @include('elements.footer_category')

                        <div class="top-col">
                            <div class="f-title mini-title primary">@lang('front.for_clients')</div>
                            <ul>
                                <li><a href="/delivery">{{ $pages['delivery'] ?? '' }}</a></li>
                                <li><a href="/faq">{{ $pages['faq'] ?? '' }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-row">
                        <div class="politic-col">
                            <a href="/policy" class="politic-link">{{ $pages['policy'] ?? '' }}</a>
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

        @yield('bodycode')

        {{-- {!! $props['body_code'] ?? '' !!} --}}

        <div class="bottom-box" style="display: grid; text-align: center; gap: 2px; padding: 30px">
            <a href="http://lingerie.bo/">home</a>
            <a href="http://lingerie.bo/catalog">catalog</a>
            <a href="http://lingerie.bo/product">product</a>
            <a href="http://lingerie.bo/cart">cart</a>
            <a href="http://lingerie.bo/checkout">checkout</a>
            <a href="http://lingerie.bo/page">page</a>
            <a href="http://lingerie.bo/faq">faq</a>
            <a href="http://lingerie.bo/success">success</a>
            <a href="http://lingerie.bo/404">404</a>
        </div>

    </body>
</html>
