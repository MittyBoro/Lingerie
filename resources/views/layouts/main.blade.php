<!DOCTYPE html>
<html lang="{{ lang() }}">
    <head>
        <meta charset="UTF-8">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <title>@yield('meta_title', 'Lingerie')</title>

        <meta name="description" content="@yield('meta_description', '')">
        <meta name="keywords" content="@yield('meta_keywords', '')" />

        <meta property="og:locale" content="{{ loc_REG() }}" />
        <meta property="og:title" content="@yield('meta_title', '')">
        <meta property="og:description" content="@yield('meta_description', '')">
        <meta property="og:type" content="@yield('meta_type', 'website')">
        @hasSection('meta_image')
        <meta property="og:image" content="@yield('meta_image')" />
        @endif
        @foreach (alt_langs(lang()) as $lang)
        <link rel="alternate" hreflang="{{ $lang }}" href="{{ replace_lang_in_url($currentUrl, $lang) }}" />
        @endforeach

        <meta name="yandex-tableau-widget" content="logo=@vite_asset('images/icons/favicon.svg'), color=#FFF2F0">
        <link rel="icon" type="image/x-icon" href="@vite_asset('images/icons/favicon.svg')">
        <link rel="apple-touch-icon" sizes="152x152" href="@vite_asset('images/icons/favicon.svg')">
        <link rel="apple-touch-icon-precomposed" sizes="152x152" href="@vite_asset('images/icons/favicon.svg')">

        @vite('resources/front/sass/style.sass')
        @vite('resources/front/js/app.js')

        @yield('head_code')
        {!! $props['head_code'] ?? '' !!}

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

    </head>
    <body class="preload page-{{ $viewName }} @yield('body_class')">
        @auth
            @includeWhen(Auth::user()->is_editor, 'elements.admin_row')
        @endauth

        <div class="preload-box">
            <a href="{{ localRoute('front.home') }}" class="loading-logo">
                @svg('images/icons/logo.svg')
            </a>
            <div class="loading-circle"></div>
            <div class="loading-text">@lang('front.loading')...</div>
        </div>

        <div class="wrapper">
            <div class="header-box" toggling>
                <div class="container">
                    <div class="hamb-wrap">
                        <div class="hamburger" toggle-click></div>
                    </div>
                    <div class="col-menu left-menu">

                        <div class="m-item"><a href="{{ localRoute('front.pages', 'catalog') }}">@lang('front.catalog')</a></div>
                        <div class="m-item">
                            <span class="a">
                                <span>@lang('front.categories')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <div class="m-item-list">
                                @foreach ($categories as $cat)
                                    <a href="{{ localRoute('front.categories', $cat['slug']) }}">{{ $cat['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="m-item"><a href="{{ localRoute('front.pages', 'delivery') }}">@lang('front.delivery')</a></div>
                    </div>
                    <a href="{{ localRoute('front.home') }}" class="logo">
                       @svg('images/icons/logo.svg')
                    </a>
                    <div class="col-menu right-menu">
                        <div class="m-item"><a href="{{ localRoute('front.pages', 'faq') }}">FAQ</a></div>
                        <div class="m-item"><a href="{{ localRoute('front.pages', 'cart') }}">@lang('front.cart') (<span class="cart-count">{{ $cartCount }}</span>)</a></div>
                        <div class="m-item">
                            <span class="a">
                                <span>@lang('front.current_lang')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <form method="post" action="/locale" class="m-item-list">
                                @csrf
                                <button name="setlang" value="ru" class="a">Русский</button>
                                <button name="setlang" value="en" class="a">English</button>
                            </form>
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
                                <li><a href="{{ localRoute('front.pages', 'delivery') }}">{{ $pages['delivery'] ?? '' }}</a></li>
                                <li><a href="{{ localRoute('front.pages', 'faq') }}">{{ $pages['faq'] ?? '' }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-row">
                        <div class="gray">
                            <a href="{{ $props['instagram'] }}" target="_blank" class="insta">
                                @svg('images/icons/instagram.svg')
                                <span>@lang('front.our_instagram')</span>
                            </a>
                        </div>
                        <div class="m-item">
                            <span class="a tar prevent">
                                <span>@lang('front.current_lang')</span>
                                <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                            </span>
                            <form method="post" action="/locale" class="m-item-list">
                                @csrf
                                <button name="setlang" value="ru" class="a">Русский</button>
                                <button name="setlang" value="en" class="a">English</button>
                            </form>
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
                                <li><a href="{{ localRoute('front.pages', 'delivery') }}">{{ $pages['delivery'] ?? '' }}</a></li>
                                <li><a href="{{ localRoute('front.pages', 'faq') }}">{{ $pages['faq'] ?? '' }}</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="bottom-row">
                        <div class="politic-col">
                            <a href="{{ localRoute('front.pages', 'policy') }}" class="politic-link">{{ $pages['policy'] ?? '' }}</a>
                        </div>
                        <div class="insta-col">
                            <a href="{{ $props['instagram'] }}" target="_blank"  class="insta">
                                @svg('images/icons/instagram.svg')
                                <span>@lang('front.our_instagram')</span>
                            </a>
                        </div>
                        <p>Legendary Lingerie © 2022</p>
                    </div>
                </div>
            </div>

        </div>

        @yield('body_code')

        {!! $props['body_code'] ?? '' !!}

        <script>
            const $lang = '{{ locale() }}';
        </script>

    </body>
</html>
