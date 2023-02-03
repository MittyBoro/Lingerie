
<div class="catalog-item" data-id="{{ $prod['id'] }}">
    <div class="catalog-images-wrapper">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach ($prod['gallery'] ?? [] as $img)
                <div class="swiper-slide">
                    <a href="{{ route('front.products', $prod['slug']) }}" class="prod-image">
                        <img src="{{ $img['thumb'] }}" alt="{{ $prod['title'] }} #{{ $loop->index }}" loading="lazy">
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @if (count($prod['gallery']) > 1)
            <div class="sw-arrow sw-prev">
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
            </div>
            <div class="sw-arrow sw-next">
                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
            </div>
        @endif
    </div>
    <a href="{{ route('front.products', $prod['slug']) }}" class="ci-name">{{ $prod['title'] }}</a>
    <div class="ci-price">
        <span class="price-el" data-cy="{{cy()}}">@price($prod['price'])</span>
    </div>
</div>
