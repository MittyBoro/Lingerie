@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('headcode')
    @vite('resources/front/js/catalog.js')
@endsection


@section('content')

<div class="catalog-box" id="catalog">
    <div class="container" :class="{'loading-blink': loading}">
        <div class="h2" ref="title" data-default="@lang('front.catalog')">{{ $page['title'] }}</div>

        <div class="catalog-mobile-sort" ref="mobiCat">
            <div class="cm-sort" toggling>
                <div class="mini-title" toggle-click>
                    <span>@lang('front.catalog_page.sort')</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                </div>
                <div class="cs-list event-links" toggle-el data-display="grid">
                    <a v-for="s in sortable"
                    v-text="s.text"
                    :href="s.href"
                    :class="{active: s.href == activeSort.href}"
                    class="sb-item"></a>
                </div>
            </div>
            <div class="btn btn-mini" @click="stopListeningFilter" filter-toggle>@lang('front.filter')</div>
        </div>

        <div class="catalog-grid grid-12">
            <div class="sidebar">
                <div class="sb-sort sb-element" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span v-text="activeSort.text"></span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list event-links" toggle-el data-display="grid">
                        <a v-for="s in sortable"
                            v-text="s.text"
                            :href="s.href"
                            :class="{active: s.href == activeSort.href}"
                            class="sb-item"></a>
                    </div>
                </div>

                <div class="sb-menu sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.category')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                        <div @click="mobileFiltering" class="btn btn-mini btn-gray prevent" filter-toggle>@lang('front.close')</div>
                    </div>
                    <div toggle-el>
                        <div v-for="parent in categories" class="sb-list">
                            <a @click="setCategory(parent)" :href="parent.href" class="sb-parent-item prevent" :class="{active: activeSlug == parent.slug}">@{{ parent.title }}</a>
                            <div class="sb-sub-list">
                                <a v-for="child in parent.children" @click="setCategory(child)" :href="child.href" class="sb-item prevent" :class="{active: activeSlug == child.slug}">@{{ child.title }}</a>
                            </div>
                        </div>
                        <div class="sb-list">
                            <a @click="setCategory(catalogLink)" :href="catalogLink.href" class="sb-parent-item prevent">@lang('front.catalog_page.all_products')</a>
                        </div>
                    </div>
                </div>

                {{-- из-за перевода проще так --}}
                @isset($options['color'])
                <div class="sb-color sb-element active" :class="{limited: colorsLimit}" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.color')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        @foreach ($options['color'] as $color)
                        <label class="sb-item">
                            <input type="checkbox" name="options" value="{{ $color['id'] }}" v-model="filter.options">
                            <div class="sbi-color" style="{{ $color['extra'] ?: '#eee' }}"></div>
                            <span>@lang('front.colors.'.$color['value'])</span>
                        </label>
                        @endforeach

                        <div @click="colorsLimit = false" class="show-more primary a">@lang('front.show_all')</div>
                    </div>
                </div>
                @endisset

                <div class="sb-price sb-element active range-sliger" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.price'), <span class="price-el" data-cy="{{cy()}}"></span></span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div toggle-el>
                        <input class="range-min" type="hidden" @change="filter.price[0] = $event.target.value" :value="filter.price[0]">
                        <input class="range-max" type="hidden" @change="filter.price[1] = $event.target.value" :value="filter.price[1]">
                        <div class="sb-list sb-range">
                            <div class="range-sliger-element" ref="priceSlider" data-min="{{ $pricesRange[0] }}" data-max="{{ $pricesRange[1] }}" data-step="1"></div>
                        </div>
                    </div>
                </div>

                @isset($options['size'])
                <div class="sb-size sb-element active" :class="{limited: sizesLimit}" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.size')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        @foreach ($options['size'] as $size)
                        <label class="sb-item">
                            <input type="checkbox" name="options" value="{{ $size['id'] }}" v-model="filter.options">
                            <span>{{ $size['value'] }}</span>
                        </label>
                        @endforeach
                        <div @click="sizesLimit = false" class="show-more primary a col-full">@lang('front.show_all')</div>
                    </div>
                </div>
                @endisset

                <div class="btns-row">
                    <div class="btn btn-mini" @click="resetFilter">@lang('front.reset')</div>
                    <div class="btn btn-mini btn-gray" @click="mobileFiltering" filter-toggle>@lang('front.close')</div>
                </div>
            </div>

            <div class="catalog-list grid-3" ref="catalogList">
                @include('elements.catalog_list')
            </div>
        </div>
    </div>
</div>

@endsection

@section('bodycode')

<script>
    const $sortable = [
        { href: '?', text: "@lang('front.catalog_page.sort_new')" },
        { href: '?sort=price-desc', text: "@lang('front.catalog_page.sort_price_desc')" },
        { href: '?sort=price-asc', text: "@lang('front.catalog_page.sort_price_asc')" },
    ];
    const $categories = @json($categories);
    const $slug = @json($slug);


</script>

@endsection
