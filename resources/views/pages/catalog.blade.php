@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_end')
    @vite('resources/front/js/catalog.js')
@endsection


@section('content')

<div class="catalog-box">
    <div class="container">
        <div class="h2">{{ $page['title'] }}</div>

        <div class="catalog-mobile-sort">
            <div class="cm-sort" toggling>
                <div class="mini-title" toggle-click>
                    <span>@lang('front.catalog_page.sort')</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                </div>
                <div class="cs-list" toggle-el data-display="grid">
                    <a href="?" class="cs-item">@lang('front.catalog_page.sort_new')</a>
                    <a href="?sort=price-desc'" class="cs-item active">@lang('front.catalog_page.sort_price_desc')</a>
                    <a href="?sort=price-asc" class="cs-item">@lang('front.catalog_page.sort_price_asc')</a>
                </div>
            </div>
            <div class="btn btn-mini" filter-toggle>фильтр</div>
        </div>

        <div class="catalog-grid grid-12">
            <div class="sidebar">
                <div class="sb-sort sb-element" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>
                            @if ($sort == 'price-desc')
                                @lang('front.catalog_page.sort_price_desc')
                            @elseif ($sort == 'price-asc')
                                @lang('front.catalog_page.sort_price_asc')
                            @else
                                @lang('front.catalog_page.sort_new')
                            @endif
                        </span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el style="display: none;" data-display="grid">
                        <a href="?" class="sb-item">@lang('front.catalog_page.sort_new')</a>
                        <a href="?sort=price-desc" class="sb-item">@lang('front.catalog_page.sort_price_desc')</a>
                        <a href="?sort=price-asc" class="sb-item">@lang('front.catalog_page.sort_price_asc')</a>
                    </div>
                </div>

                <div class="sb-menu sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.category')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                        <div class="btn btn-mini btn-gray prevent" filter-toggle>@lang('front.close')</div>
                    </div>
                    <div toggle-el>
                        @foreach ($categories as $pCat)
                        <div class="sb-list">
                            <a href="{{ route('front.categories', $pCat['slug']) }}" class="sb-parent-item">{{ $pCat['title'] }}</a>
                            <div class="sb-sub-list">
                                @foreach ($pCat['children'] as $cat)
                                    <a href="{{ route('front.categories', $cat['slug']) }}" class="sb-item {{ $cat['slug'] == $slug ? 'active' : '' }}">{{ $cat['title'] }}</a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="sb-color sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.color')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        @foreach ($colors as $color)
                        <label class="sb-item">
                            <input type="checkbox" name="color" value="{{ $color['value'] }}">
                            <div class="sbi-color" style="background-color: {{ $color['extra'] ?: '#eee' }}"></div>
                            <span>@lang('front.colors.'.$color['value'])</span>
                        </label>
                        @endforeach

                        <div class="show-more primary a">@lang('front.show_all')</div>
                    </div>
                </div>

                <div class="sb-price sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.price'), {{ $cySymb }}</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div toggle-el>
                        <input class="range-end" type="hidden" v-model="filter.price.maxRange" @change="updateSlider('price')">
                        <input class="range-start" type="hidden" v-model="filter.price.minRange" @change="updateSlider('price')">
                        <div class="sb-list sb-range">
                            <div class="sb-range-price" ref="priceSlider" data-min="{{ $min_price }}" data-max="{{ $max_price }}" data-step="1"></div>
                        </div>
                    </div>
                </div>

                <div class="sb-size sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.size')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        @foreach ($sizes as $size)
                        <label class="sb-item">
                            <input type="checkbox" name="size" value="{{ $size['value'] }}">
                            <span>{{ $size['value'] }}</span>
                        </label>
                        @endforeach
                        <div class="show-more primary a col-full">@lang('front.show_all')</div>
                    </div>
                </div>
                <div class="btns-row">
                    <div class="btn btn-mini">@lang('front.reset')</div>
                    <div class="btn btn-mini btn-gray" filter-toggle>@lang('front.close')</div>
                </div>
            </div>

            <div class="catalog-list grid-3">
                @foreach ($products as $prod)
                    @include('elements.catalog_item')
                @endforeach
                @if ($products->hasPages())
                    <div class="catalog-bottom-row col-full">
                        <div class="btn btn-show-more">@lang('front.show_more')</div>
                        {{ $products->links('elements.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
