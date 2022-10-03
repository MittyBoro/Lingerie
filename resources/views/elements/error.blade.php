@if ($errors->isNotEmpty())
	<div class="error-text">
		@foreach ($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
@endif
