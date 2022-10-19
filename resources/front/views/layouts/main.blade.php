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

        {{-- <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css', 'assets') }}"> --}}

        @yield('head_end')
        {{-- {!! $props['head_code'] ?? '' !!} --}}

    </head>
    <body class="preload page-{{ $view_name }}">
        {{-- @auth
            @includeWhen(Auth::user()->is_editor, 'elements.admin_row')
        @endauth --}}

        <div class="wrapper">

            <div class="header">
                <div class="container">
                </div>
            </div>


            @yield('content')


            <div class="footer">
                <div class="container">
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
