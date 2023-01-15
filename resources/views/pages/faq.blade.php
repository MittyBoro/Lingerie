@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="faq-box page-box">
    <div class="container">
        <h1 class="h2">частые вопросы</h1>
        <div class="faq-list">
            <div class="faq-item" toggling>
                <div class="faq-title" toggle-click>
                    <span>Могу ли я оформить заказ по телефону?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el style="display: none">Всdddddddd</div>
            </div>
            <div class="faq-item active" toggling>
                <div class="faq-title" toggle-click>
                    <span>Я хочу сделать подарок. Как будет выглядит упаковка заказа?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el>Все заказы, сделанные в интернет-магазине, бережно упаковываются в наш розовую брендированную коробку, перевязанную черной атласной ленточкой. Перед отправкой заказа мы помещаем розовую коробку в крафтовый короб. На внешней упаковке указан только адрес получателя и не указан отправитель заказа и его содержимое, что обеспечивает полную анонимность.</div>
            </div>
            <div class="faq-item" toggling>
                <div class="faq-title" toggle-click>
                    <span>Сколько вещей я могу оформить в одном заказе?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el>Всdddddddd</div>
            </div>
            <div class="faq-item" toggling>
                <div class="faq-title" toggle-click>
                    <span>Я сомневаюсь в выборе размера товара. Как мне быть?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el>Всdddddddd</div>
            </div>
            <div class="faq-item" toggling>
                <div class="faq-title" toggle-click>
                    <span>Как быстро доставят мой заказ?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el>Всdddddddd</div>
            </div>
            <div class="faq-item" toggling>
                <div class="faq-title" toggle-click>
                    <span>Что делать, если нужного мне товара нет в наличии?</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="icon to-svg">
                </div>
                <div class="faq-value" toggle-el>Всdddddddd</div>
            </div>
        </div>
    </div>
</div>

@endsection
