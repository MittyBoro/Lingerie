@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="white-box success-box">
    <div class="container">
        <div class="white-item">
            <div class="h1"><span class="color">спасибо</span> за заказ!</div>
            <div class="wh-subinfo">Мы вышлем на ваш E-mail детали заказа и трек номер для отслеживания.</div>
            <a href="#" class="btn">назад к покупкам</a>
        </div>
    </div>
</div>

@endsection
