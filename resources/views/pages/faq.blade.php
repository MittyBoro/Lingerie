@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="faq-box page-box">
    <div class="container">
        <h1 class="h2">{{ $page['title'] }}</h1>
        <div class="faq-list">
            @foreach ($faq as $f)

                <div class="faq-item {{ $loop->first ? 'active' : '' }}" toggling>
                    <div class="faq-title" toggle-click>
                        <span>{{ $f['title'] }}</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                    </div>
                    <div class="faq-value" toggle-el>{{ $f['description'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
