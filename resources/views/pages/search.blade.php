@extends('layouts.main')

@section('meta_title', 'Результаты по запросу «' . $q . '» | ' . config('app.name'))

@section('content')


<div class="news-box">
	<div class="container">

		@if ($products->isNotEmpty() || $posts->isNotEmpty())

			<h1 class="h2 h2-title">Поиск по запросу «{{ $q }}»</h1>

			@if ($products->isNotEmpty())
				<h2 class="h3 h2-title">Магазин:</h2>
				<div class="catalog-list">

					@forelse ($products as $prod)
						@include('elements.product_item')
					@endforeach

					{{ $products->links('elements.pagination') }}
				</div>
			@endif

			@if ($posts->isNotEmpty())
				<h2 class="h3 h2-title">Блог:</h2>
				<div class="news-list">

					@forelse ($posts as $article)
						@include('elements.post_item')
					@endforeach

					{{ $posts->links('elements.pagination') }}
				</div>
			@endif
		@else
			<div class="nothing">
				<h1 class="h2 h2-title">По запросу «{{ $q }}» ничего не найдено</h1>
				<a href="/shop" class="btn btn-mini">Перейти в каталог</a>
			</div>
		@endif

	</div>
</div>


@endsection
