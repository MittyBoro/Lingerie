@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')
@section('body_class', 'page-white')

@section('content')

<div class="page-box white-box success-box">
    <div class="container">
        <div class="white-item">
            <div class="h1">
                <div><span class="secondary">спасибо</span> за заказ!</div>
            </div>
            <div class="wh-subinfo">Мы вышлем на ваш E-mail детали заказа и трек номер для отслеживания.</div>
            <a href="#" class="btn">назад к покупкам</a>
        </div>
    </div>
</div>

@endsection
