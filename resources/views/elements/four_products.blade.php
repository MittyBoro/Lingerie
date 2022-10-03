
<div class="catalog-list swiper-catalog">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			@foreach ($products as $prod)
				<div class="swiper-slide">
					@include('elements.product_item')
				</div>
			@endforeach
		</div>
		<div class="swiper-navigation">
			<div class="swiper-nav-bottom">
				<div class="swiper-button swiper-button-prev">
					@svg('images/svg/arrow.svg')
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button swiper-button-next">
					@svg('images/svg/arrow.svg')
				</div>
			</div>
		</div>
	</div>
</div>
