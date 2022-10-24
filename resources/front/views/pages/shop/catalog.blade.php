@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('content')

<div class="catalog-box">
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-sort sb-element">
                <div class="sb-title">сначала новое</div>
                <div class="sb-list">
                    <div class="sb-item">Сначала новое</div>
                    <div class="sb-item active">Цены по убыванию</div>
                    <div class="sb-item">Цены по возраfстанию</div>
                </div>
                <div class="active"></div>
            </div>

            <div class="sidebar-menu sb-element">
                <div class="sb-title">категория</div>
                <div class="sb-list">
                    <div class="sb-item">
                        <span>Нижнее белье</span>
                        <div class="sb-sub-list">
                            <div class="sb-item">Бюстгальтеры</div>
                            <div class="sb-item">Трусики</div>
                            <div class="sb-item active">Пояса</div>
                            <div class="sb-item">Комплекты</div>
                        </div>
                    </div>
                    <div class="sb-item">
                        <span>Купальники</span>
                        <div class="sb-sub-list">
                            <div class="sb-item">Слитные</div>
                            <div class="sb-item">Раздельные</div>
                        </div>
                    </div>
                    <div class="sb-item">
                        <span>Одежда для дома</span>
                        <div class="sb-sub-list">
                            <div class="sb-item">Пижамы</div>
                            <div class="sb-item">Халаты</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-color sb-element">
                <div class="sb-title">выбор цвета</div>
                <div class="sb-list">
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #fff"></div>
                        <span>Белый</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #676767"></div>
                        <span>Черный</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #EA5D5D"></div>
                        <span>Красный</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #F67FC6"></div>
                        <span>Розовый</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #88DD61"></div>
                        <span>Зеленый</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="color">
                        <div class="sbi-color" style="background-color: #fff"></div>
                        <span>Белый</span>
                    </div>
                    <div class="sb-item show-more">Показать все</div>
                </div>
            </div>

            <div class="sidebar-price sb-element">
                <div class="sb-title">Цена</div>
                <div class="sb-range">
                </div>
            </div>

            <div class="sidebar-size sb-element">
                <div class="sb-title">размер</div>
                <div class="sb-list">
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>L</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>L</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>М</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>М</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>S</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>S</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>XL</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>XL</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>XS</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>XS</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>L</span>
                    </div>
                    <div class="sb-item">
                        <input type="checkbox" name="size">
                        <span>L</span>
                    </div>
                    <div class="sb-item show-more">Показать все</div>
                </div>
            </div>

            <div class="btn btn-alt">сбросить</div>
        </div>
        <div class="catalog-list">

            @foreach (range(0, 6) as $i)
                <div class="catalog-item">
                    <div class="catalog-images">
                        <img src="/storage/tmp/1.png" alt="">
                    </div>
                    <a href="#">Длинный заголовок чудесного товара</a>
                    <div class="ci-price"><span>4990</span> ₽</div>
                </div>
            @endforeach
            <div class="catalog-bottom-row">
                <div class="btn btn-show-more">показать еще</div>
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

@endsection
