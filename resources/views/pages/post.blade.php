@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('meta_type', 'article')
@section('meta_image', $post->preview)

@section('content')

<div class="article-box">
	<div class="container">

		<div class="breadcrumb">
			<a href="/">Главная</a> /
			<a href="/news">Блог</a> /
			<span>{{ $page['title'] }}</span>
		</div>

		<h1 class="h2 article-title">{{ $page->title }}</h1>

		<div class="article-date">{{ $post->published_formated }}</div>

		<div class="article-content text-box">
			{!! $post->description !!}
		</div>

		@if ($post->partner)
			<div class="partner">
				@include('elements.franchisee_item', ['item' => $post->partner])
				<div class="partner-text text-box">{!! $post->partner->description !!}</div>
			</div>
		@endif

		@if ($post->photos->isNotEmpty())
			<div class="gallery lightgallery">
				@foreach ($post->photos as $image)
				<a href="{{ $image['big'] }}">
					<img alt="" src="{{ $image['thumb'] }}"" />
				</a>
				@endforeach
			</div>
		@endif

		@if ($post->videos->isNotEmpty())
			<div class="video-list">
				@foreach ($post->videos as $video)
				<video style="max-width: 100%;" controls="controls" width="700" height="450">
					<source src="{{ $video }}">
				</video>
				@endforeach
			</div>
		@endif

	</div>
</div>



<div class="news-box">
	<div class="container">
		<h2 class="h2 h2-title">Другие наши новости</h2>
		<div class="news-list">
			@foreach ($similar as $a)
				@include('elements.post_item', ['article' => $a])
			@endforeach
		</div>
	</div>
</div>

<div class="blog-subscribe order-form">
	<div class="container">
		<div class="top-row">
			<div class="h3">Подпишитесь на рассылку, чтобы быть в курсе наших последних событий и новостей</div>
		</div>

		<form @submit.prevent="submit" class="form-subscribe col-xl-10">
			<input type="hidden" :value="form.form = 'blog_subscribe'">
			<div class="f-wrap">
				<input placeholder="text" type="text" autocomplete="email" v-model="form.email" required>
				<div class="f-placeholder">Ваша почта</div>
			</div>
			<div class="space"></div>
			<button class="btn btn-double" :disabled="disabled" :class="{ 'btn-success': success }">
				<span :class="{ hidden: success }">Подписаться</span>
				<span :class="{ hidden: !success }">Готово</span>
			</button>
			<div class="space"></div>
			<label class="agreement">
				<input type="checkbox" required checked>
				<span>Я даю согласие на обработку<br>персональных данных</span>
			</label>
		</form>

	</div>
</div>

@endsection


@section('body_end')
	<script src="{{ mix('js/gallery.js', 'assets') }}" defer></script>
@endsection
