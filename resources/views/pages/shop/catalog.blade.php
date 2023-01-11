@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="catalog-box">
    <div class="container">
        <div class="h2">Каталог</div>

        <div class="grid-grid grid-12">
            <div class="sidebar">
                <div class="sb-sort sb-element" toggle-parent>
                    <div class="sb-title mini-title" toggle-click>
                        <span>сначала новое</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el style="display: none;" data-display="grid">
                        <div class="sb-item">Сначала новое</div>
                        <div class="sb-item active">Цены по убыванию</div>
                        <div class="sb-item">Цены по возрастанию</div>
                    </div>
                </div>

                <div class="sb-menu sb-element active" toggle-parent>
                    <div class="sb-title mini-title" toggle-click>
                        <span>категория</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div toggle-el>
                        <div class="sb-list">
                            <a href="#" class="sb-parent-item">Нижнее белье</a>
                            <div class="sb-sub-list">
                                <a href="#" class="sb-item">Бюстгальтеры</a>
                                <a href="#" class="sb-item">Трусики</a>
                                <a href="#" class="sb-item active">Пояса</a>
                                <a href="#" class="sb-item">Комплекты</a>
                            </div>
                        </div>
                        <div class="sb-list">
                            <a href="#" class="sb-parent-item">Купальники</a>
                            <div class="sb-sub-list">
                                <a href="#" class="sb-item">Слитные</a>
                                <a href="#" class="sb-item">Раздельные</a>
                            </div>
                        </div>
                        <div class="sb-list">
                            <a href="#" class="sb-parent-item">Одежда для дома</a>
                            <div class="sb-sub-list">
                                <a href="#" class="sb-item">Пижамы</a>
                                <a href="#" class="sb-item">Халаты</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sb-color sb-element active" toggle-parent>
                    <div class="sb-title mini-title" toggle-click>
                        <span>выбор цвета</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        <label class="sb-item">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #fff; border: 1px solid #D9D9D9;"></div>
                            <span>Белый</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #676767"></div>
                            <span>Черный</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #EA5D5D"></div>
                            <span>Красный</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #F67FC6"></div>
                            <span>Розовый</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #88DD61"></div>
                            <span>Зеленый</span>
                        </label>
                        <label class="sb-item" style="display:none">
                            <input type="checkbox" name="color">
                            <div class="sbi-color" style="background-color: #fff"></div>
                            <span>Белый</span>
                        </label>
                        <div class="show-more primary a">Показать все</div>
                    </div>
                </div>

                <div class="sb-price sb-element active" toggle-parent>
                    <div class="sb-title mini-title" toggle-click>
                        <span>Цена, ₽</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div toggle-el>
                        <input class="range-end" type="hidden" v-model="filter.price.maxRange" @change="updateSlider('price')">
                        <input class="range-start" type="hidden" v-model="filter.price.minRange" @change="updateSlider('price')">
                        <div class="sb-list sb-range">
                            <div class="sb-range-price" ref="priceSlider" data-min="0" data-max="30000" data-step="100"></div>
                        </div>
                    </div>
                </div>

                <div class="sb-size sb-element active" toggle-parent>
                    <div class="sb-title mini-title" toggle-click>
                        <span>размер</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>L</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>L</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>М</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>М</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>S</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>S</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>XL</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>XL</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>XS</span>
                        </label>
                        <label class="sb-item">
                            <input type="checkbox" name="size">
                            <span>XS</span>
                        </label>
                        <label class="sb-item" style="display: none">
                            <input type="checkbox" name="size">
                            <span>L</span>
                        </label>
                        <label class="sb-item" style="display: none">
                            <input type="checkbox" name="size">
                            <span>L</span>
                        </label>
                        <div class="show-more primary a col-full">Показать все</div>
                    </div>
                </div>

                <div class="btn btn-mini">сбросить</div>
            </div>

            <div class="catalog-list grid-3">
                @foreach (range(1, 6) as $i)
                    <div class="catalog-item">
                        <div class="catalog-images">
                            <img src="/storage/tmp/1.png" alt="">
                        </div>
                        <a href="#">Длинный заголовок чудесного товара</a>
                        <div class="ci-price"><span>4990</span> ₽</div>
                    </div>
                @endforeach
                <div class="catalog-bottom-row col-full">
                    <div class="btn btn-show-more">показать еще</div>
                    <div class="pagintaion">
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>Следующая</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
