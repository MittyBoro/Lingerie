
<ul class="sb-menu">
	@foreach ($categories as $cat)
		<li class="@if ($cat->depth) depth @endif">
			<a
			@isset($cat->slug)
				href="/category/{{ $cat->slug }}"
			@else
				href="{{ $cat->url ?? '/' }}"
			@endisset
			>{{ $cat->title }}
				@isset($cat->models_count)
				<span class="sb-count">({{ $cat->models_count }})</span>
				@endisset
			</a>
		</li>
	@endforeach
	<li class="gray"><a href="/shop">Все</a></li>
</ul>
