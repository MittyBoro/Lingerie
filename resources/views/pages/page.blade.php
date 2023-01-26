@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="page-box">
    <div class="container">
        <h1 class="h2">{{ $page['title'] }}</h1>
        <div class="page-text text-el">
            {!! $page['description'] !!}
        </div>
    </div>
</div>

@endsection
