@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="faq-box">
    <div class="container">
        <h1 class="h2">частые вопросы</h1>
        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-title">Могу ли я оформить заказ по телефону?</div>
                <div class="faq-value">Всdddddddd</div>
            </div>
            <div class="faq-item active">
                <div class="faq-title">Я хочу сделать подарок. Как будет выглядит упаковка заказа?</div>
                <div class="faq-value">Все заказы, сделанные в интернет-магазине, бережно упаковываются в наш розовую брендированную коробку, перевязанную черной атласной ленточкой. Перед отправкой заказа мы помещаем розовую коробку в крафтовый короб. На внешней упаковке указан только адрес получателя и не указан отправитель заказа и его содержимое, что обеспечивает полную анонимность.</div>
            </div>
            <div class="faq-item">
                <div class="faq-title">Сколько вещей я могу оформить в одном заказе?</div>
                <div class="faq-value">Всdddddddd</div>
            </div>
            <div class="faq-item">
                <div class="faq-title">Я сомневаюсь в выборе размера товара. Как мне быть?</div>
                <div class="faq-value">Всdddddddd</div>
            </div>
            <div class="faq-item">
                <div class="faq-title">Как быстро доставят мой заказ?</div>
                <div class="faq-value">Всdddddddd</div>
            </div>
            <div class="faq-item">
                <div class="faq-title">Что делать, если нужного мне товара нет в наличии?</div>
                <div class="faq-value">Всdddddddd</div>
            </div>
        </div>
    </div>
</div>

@endsection
