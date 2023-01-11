@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="product-box">
    <div class="container">
        <div class="prod-grid grid-12">
            <div class="prod-main-col">
                <div class="breadcrumbs">
                    <a href="#">Главная</a>
                    <span class="delimeter">/</span>
                    <a href="#">Нижнее белье</a>
                    <span class="delimeter">/</span>
                    <a href="#">Пояса</a>
                </div>
                <div class="prod-title"><h1>Длинный заголовок чудесного товара</h1></div>

                <div class="prod-attr-wrap">
                    <div class="pm-title">Размер</div>
                    <div class="pm-list pm-size">
                        <label class="form-radio pm-item">
                            <input type="radio" name="size">
                            <div class="fr-item">
                                <span>XS</span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="size">
                            <div class="fr-item">
                                <span>S</span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="size">
                            <div class="fr-item">
                                <span>M</span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="size">
                            <div class="fr-item">
                                <span>L</span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="size">
                            <div class="fr-item">
                                <span>XL</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="prod-attr-wrap">
                    <div class="pm-title">Цвет</div>
                    <div class="pm-list pm-color">
                        <label class="form-radio pm-item">
                            <input type="radio" name="color" value="1">
                            <div class="fr-item">
                                <span style="background-color: #fff; border: 1px solid #D9D9D9;"></span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="color" value="2">
                            <div class="fr-item">
                                <span style="background-color: #F67FC6"></span>
                            </div>
                        </label>
                        <label class="form-radio pm-item">
                            <input type="radio" name="color" value="3">
                            <div class="fr-item">
                                <span style="background-color: #88DD61"></span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="prod-price">4990 ₽</div>
                <div class="btn">добавить в корзину</div>
            </div>

            <div class="gallery-col">
                <div class="full-row">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            @foreach ([1, 2, 1, 2, 1, 2] as $i)
                                <div class="swiper-slide">
                                    <div class="gallery-image zoom-image" style="background-image: url('/storage/tmp/{{ $i }}.png')"><img src="/storage/tmp/{{ $i }}.png" alt=""></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="sw-arrow sw-prev">
                        <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                    </div>
                    <div class="sw-arrow sw-next">
                        <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                    </div>
                </div>
                <div class="thumbs-row">
                    <div class="swiper-scrollbar"></div>
                    <div class="swiper-container">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach ([1, 2, 1, 2, 1, 2] as $i)
                                    <div class="swiper-slide">
                                        <div class="gallery-image"><img src="/storage/tmp/{{ $i }}.png" alt=""></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="bottom-info-col">
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
            </div> --}}
        </div>
    </div>
</div>

<div class="catalog-box product-catalog-box">
    <div class="container">
        <div class="handwritten">Look</div>
        <div class="h2">вам может понравиться</div>
        <div class="catalog-list grid-4">
            @foreach (range(1, 4) as $i)
                <div class="catalog-item">
                    <div class="catalog-images-wrapper">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach (range(1, 3) as $i)
                                    <div class="swiper-slide">
                                        <a href="#" class="catalog-image"><img src="/storage/tmp/{{ rand(1, 2) }}.png" alt=""></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="sw-arrow sw-prev">
                            <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                        </div>
                        <div class="sw-arrow sw-next">
                            <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                        </div>
                    </div>
                    <a href="#" class="ci-name">Длинный заголовок чудесного товара</a>
                    <div class="ci-price"><span>4990</span> ₽</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
