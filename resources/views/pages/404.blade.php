@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="page-box white-box error-box">
    <div class="container">
        <div class="white-item">
            @svg('/images/icons/404.svg')
            <div class="wh-subinfo">Упс... Кажется вы потерялись, потому что такой страницы не существует.</div>
            <a href="#" class="btn">назад к покупкам</a>
        </div>
    </div>
</div>

@endsection
