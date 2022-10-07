@extends('layouts.main')

@section('meta_title', $page['meta_title'])
@section('meta_description', $page['meta_description'])
@section('meta_keywords', $page['meta_keywords'])

@section('content')

<div class="franchisee-box" id="partners">
    <div class="container">

        <div class="breadcrumb">
            <a href="/">Главная</a> /
            <span>{{ $page['title'] }}</span>
        </div>

        <h1 class="h2 h2-title">{{ $page['title'] }}</h1>

        <div class="form-box">
            <div class="left-text">
                {!! $page['description'] !!}
            </div>
            <div class="right-form">
                <div class="f-wrap">
                    <input placeholder="text" v-model="city" type="text">
                    <div class="f-placeholder">Введите ваш город</div>
                    <div class="btn">
                        @svg('images/svg/search.svg')
                    </div>
                </div>
            </div>
        </div>

        <div class="franchisee-flex">
            <div class="col-lg-5 col-md-6 fr-list-wrap">
                <div class="fr-list">
                    @foreach ($partners as $item)
                        @include('elements.franchisee_item', ['item' => $item])
                    @endforeach
                    <div class="list-empty h2">
                        Ничего не найдено :(
                    </div>
                </div>
            </div>
            <div class="space"></div>
            <div class="col-lg-7 col-md-6">
                <div id="map"></div>
            </div>
        </div>

    </div>
</div>
@endsection
