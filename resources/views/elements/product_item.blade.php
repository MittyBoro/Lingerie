
<div class="product-item @if (!$prod->is_stock) not-available @endif">
	<a href="/product/{{ $prod->slug }}" class="prod-preview">
		<img src="{{ $prod->preview }}" alt="{{ $prod->title }}">
		<span class="prod-more">
			<span class="btn-mini btn-white">Подробнее</span>
			{{-- <span class="prod-to-cart"></span> --}}
		</span>
	</a>
	<h3 class="prod-title"><a href="/product/{{ $prod->slug }}">{{ $prod->title }}</a></h3>
	@if ($prod->is_stock)
		<div class="prod-price">@if ($prod->variations_count > 1) от @endif{{ format_price($prod->min_price) }}₽</div>
		<a href="/product/{{ $prod->slug }}" class="btn-mini btn">Купить</a>
	@else
		<div class="prod-price">Снято с производства</div>
	@endif
</div>
