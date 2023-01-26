
@foreach ($products as $prod)
    @include('elements.catalog_item')
@endforeach
@if ($products->hasPages())
    <div class="catalog-bottom-row col-full">
        <div class="btn btn-show-more">@lang('front.show_more')</div>
        {{ $products->links('elements.pagination') }}
    </div>
@endif
