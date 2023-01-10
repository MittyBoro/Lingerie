@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="product-box">
    <div class="container">
        <div class="top-info-col">
            <div class="breadcrumbs">
                <a href="#">Главная</a>
                <span class="delimeter">/</span>
                <a href="#">Нижнее белье</a>
                <span class="delimeter">/</span>
                <a href="#">Пояса</a>
            </div>
            <h2 class="h2">Длинный заголовок чудесного товара</h2>

            <div class="prod-attr-wrap">
                <div class="pa-title">Размер</div>
                <div class="pa-list pa-size">
                    <div class="pa-item">
                        <input type="radio" name="size">
                        <span>XS</span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="size">
                        <span>S</span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="size">
                        <span>M</span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="size">
                        <span>L</span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="size">
                        <span>XL</span>
                    </div>
                </div>
            </div>
            <div class="prod-attr-wrap">
                <div class="pa-title">Цвет</div>
                <div class="pa-list pa-color">
                    <div class="pa-item">
                        <input type="radio" name="color">
                        <span style="background-color: #fff"></span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="color">
                        <span style="background-color: #F67FC6"></span>
                    </div>
                    <div class="pa-item">
                        <input type="radio" name="color">
                        <span style="background-color: #88DD61"></span>
                    </div>
                </div>
            </div>
            <div class="prod-price">4990 ₽</div>
            <div class="btn">добавить в корзину</div>
        </div>
        <div class="gallery-col">
            <div class="big-images-row">
                <img src="/storage/tmp/1.png" alt="">
            </div>
            <div class="thumbs-row">
                <img src="/storage/tmp/1.png" alt="">
                <img src="/storage/tmp/2.png" alt="">
            </div>
        </div>
        <div class="bottom-info-col">
            <div class="bi-item">
                <div class="b-title">Описание</div>
                <div class="bi-text">Этот пояс для чулок из лаконичной и в то же время чувственной коллекции Henrieta выполнен из розового тюля. Передняя панель украшена вышивкой с растительным мотивом. Края обрамлены эластичными лентами. </div>
            </div>
            <div class="bi-item">
                <div class="b-title">Состав</div>
                <div class="bi-text">Верхний слой с вышивкой: Основа: 100% полиамид, Вышивка: 100% полиэстер, Сетчатый верхний слой: 100% полиамид. </div>
            </div>
            <div class="bi-item">
                <div class="b-title">уход</div>
                <div class="bi-text">Рекомендована раздельная ручная стирка и бережная сушка.</div>
            </div>
        </div>
        <div class="bottom-table-col">
            <div class="b-title">таблица размеров</div>
            <img src="/storage/tmp/table.png" alt="">
        </div>
    </div>
</div>

<div class="catalog-box product-catalog-box">
    <div class="container">
        <div class="handwritten">Look</div>
        <div class="h2">вам может понравиться</div>
        <div class="catalog-list">
            @foreach (range(0, 3) as $i)
                <div class="catalog-item">
                    <div class="catalog-images">
                        <img src="/storage/tmp/1.png" alt="">
                    </div>
                    <a href="#">Длинный заголовок чудесного товара</a>
                    <div class="ci-price"><span>4990</span> ₽</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
