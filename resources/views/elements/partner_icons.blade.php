
<div class="f-icons f-icons-partners">
	@foreach ($information as $info)
		@if ($info['type'] == 'url')
			<p><a rel="nofollow" href="{{ $info['value'] }}">{{ $info['value'] }}</a></p>
		@elseif ($info['type'] == 'vk')
			<a rel="nofollow" href="{{ $info['value'] }}">
				@svg('images/svg/vk.svg')
			</a>
		@elseif ($info['type'] == 'instagram')
			{{-- <a href="{{ $info['value'] }}">
				@svg('images/svg/instagram.svg')
			</a> --}}
		@elseif ($info['type'] == 'phone')
			<a rel="nofollow" href="tel:{{ $info['value'] }}">
				@svg('images/svg/phone_round.svg')
				<span>{{ $info['value'] }}</span>
			</a>
		@else
			<p>{{ $info['value'] }}</p>
		@endif
	@endforeach
</div>
