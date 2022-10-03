@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('head_end')
	<link rel="canonical" href="{{ url('/' . $page['slug']) }}">
@endsection


@section('content')
	<div class="news-box">
		<div class="container">

			<div class="breadcrumb">
				<a href="/">Главная</a> /
				<span>{{ $page['title'] }}</span>
			</div>

			<h1 class="h2 h2-title">{{ $page['title'] }}</h1>

			<div class="page-description">{!! $page['description'] !!}</div>

			<div class="news-list">

				@forelse ($news as $article)
					@include('elements.post_item')
				@empty
					<div class="empty flex-center grid-full mx-10">
						<div class="h1">Здесь ничего нет</div>
					</div>
				@endforelse

				{{ $news->links('elements.pagination') }}
			</div>

		</div>
	</div>
@endsection
