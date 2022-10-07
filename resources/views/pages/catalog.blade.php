@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])


@section('head_end')
    <link rel="canonical" href="{{ url('/shop') }}">
@endsection

@section('content')


<div class="catalog-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /

            @if ($page['slug'] != 'shop')
                <a href="/shop">Каталог</a> /
            @endif

            @if ($category)
                @foreach($category->ancestors as $anc)
                    <a href="/category/{{ $anc->slug }}">{{ $anc->title }}</a> /
                @endforeach
            @endif

            <span>{{ $page['title'] }}</span>
        </div>

        <h1 class="h2 h2-title">{{ $page['title'] }}</h1>

        <div class="catalog-description">
            {!! $page['description'] !!}
        </div>

        <div class="catalog-content">
            <div class="sidebar">
                <div class="line-title ttu">Категории товаров</div>

                @include('elements.catalog_menu', ['categories' => $categories])

                <div class="sb-delivery">
                    {!! nl2br($props['shipping_text']) !!}
                </div>

                <div class="f-icons">
                    <a target="_blank" href="{{ $props['vk'] }}">
                        @svg('images/svg/vk.svg')
                    </a>
                    <a target="_blank" href="{{ $props['vk_group'] }}">
                        @svg('images/svg/vk.svg')
                    </a>
                    {{-- <a target="_blank" href="{{ $props['instagram'] }}">
                        @svg('images/svg/instagram.svg')
                    </a> --}}
                </div>
            </div>
            <div class="catalog-list catalog-grid">
                <div class="grid-full catalog-top-line">
                    <div class="ctl-mini-menu">
                        <div class="btn btn-mini cats-toggle">Категории</div>
                        @include('elements.catalog_menu', ['categories' => $categories])
                    </div>
                    <div class="cat-header">
                        <div class="cat-sort">
                            <div class="line-title current-sort-name"></div>
                            <div class="sort-list">
                                <a href="{{ url()->current() }}">Сначала популярное</a>
                                <a href="?orderby=created_at%2Casc">Сначала новое</a>
                                <a href="?orderby=min_price%2Casc">Сначала дешевле</a>
                                <a href="?orderby=min_price%2Cdesc">Сначала дороже</a>
                            </div>
                        </div>
                    </div>
                </div>

                @forelse ($products as $prod)
                    @include('elements.product_item')
                @empty

                    <div class="empty flex-center grid-full mx-10">
                        <div class="h1">Здесь ничего нет</div>
                    </div>

                @endforelse

                {{ $products->links('elements.pagination') }}
            </div>


        </div>

        @if (isset($page['footer_description']))
            <div class="catalog-after-description">
                {!! $page['footer_description'] !!}
            </div>
        @elseif (isset($page->props['bottom_text']))
            <div class="catalog-after-description">
                {!! $page->props['bottom_text'] !!}
            </div>
        @endif


    </div>
</div>


@endsection

@section('body_end')

    <script>
        const urlprops = new URLSearchParams(window.location.search);
        const orderby = urlprops.get('orderby');

        document.querySelectorAll('.cat-sort .sort-list a').forEach(el => {
            let currentUrl = new URLSearchParams(el.getAttribute('href'));

            if (currentUrl.get('orderby') == orderby) {
                el.classList.add('active');

                document.querySelector('.cat-sort .current-sort-name').textContent = el.textContent
            }
        });
    </script>

@endsection
