@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="article-box">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>{{ $page['title'] }}</span>
        </div>

        <h1 class="h2 h2-title">{{ $page->title }}</h1>

        <div class="article-content text-box">
            {!! $page->description !!}
        </div>
    </div>
</div>

@endsection
