
@forelse ($products as $prod)
    @include('elements.catalog_item')
@empty
    <div class="col-full white-box event-links">
        <div class="white-item">
            <div class="h2 tac">@lang('front.catalog_page.not_found')</div>
            <a href="{{ localeRoute('front.pages', 'catalog') }}" class="btn">@lang('front.to_catalog')</a>
        </div>
    </div>
@endforelse

@if ($products->hasPages())
    <div class="catalog-bottom-row col-full event-links">
        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="btn btn-show-more">@lang('front.show_more')</a>
        @endif
        {{ $products->links('elements.pagination') }}
    </div>
@endif
