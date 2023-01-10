@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="page-box">
    <div class="container">
        <h1 class="h2">Доставка</h1>
        <div class="page-text">
            <h2>Текст</h2>
            <p>Доставка в день заказа в пределах КАД, при условии если заказ оплачен и товар в наличии на складе (заказы, оформленные после 15:00, будут доставлены на следующий день) — 400 руб.</p>
            <p>Если выбранного товара нет в наличии на складе, срок доставки заказа от 3 до 5 рабочих дней.</p>
            <p>При выборе доставки в пределах КАД доступна услуга примерки.</p>
            <p>Стоимость доставки за пределы КАД (доставка осуществляется курьерской службой СДЭК и доступна только при 100% предоплате) — 450 руб. Срок сборки заказа от 1 до 3 рабочих дней.</p>

            <h2>Маркерованный список</h2>
            <ul>
                <li>Доставка в день заказа</li>
                <li>Будут доставлены на следующий день</li>
                <li>При выборе доставки в пределах КАД доступна услуга</li>
                <li>Доставка осуществляется курьерской службой</li>
            </ul>
        </div>
    </div>
</div>

@endsection