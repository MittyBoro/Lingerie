@extends('layouts.main')

@section('meta_title', 'Страница не найдена')
@section('wrapper_class', 'page-404')

@section('content')


<div class="four-box">
    <div class="container">
        <img src="{{ asset('images/404.png') }}" alt="">
        <div class="h2">Страница не найдена</div>
        <a href="/" class="btn-mini">На главную</a>
    </div>
</div>





@endsection


@section('end_content')
    <script src="{{ mix('js/gallery.js', 'assets') }}" defer></script>
@endsection
