@extends('layouts.main')

@section('meta_title', $page['meta_title'] ?? '')
@section('meta_description', $page['meta_description'] ?? '')
@section('meta_keywords', $page['meta_keywords'] ?? '')

@section('head_end')
    @vite('resources/front/js/catalog.js')
@endsection


@section('content')

<div class="catalog-box">
    <div class="container">
        <div class="h2">@lang('front.catalog_page.catalog')</div>

        <div class="catalog-mobile-sort">
            <div class="cm-sort" toggling>
                <div class="mini-title" toggle-click>
                    <span>@lang('front.catalog_page.sort')</span>
                    <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                </div>
                <div class="cs-list" toggle-el data-display="grid">
                    <div class="cs-item">@lang('front.catalog_page.sort_new')</div>
                    <div class="cs-item active">@lang('front.catalog_page.sort_price_desc')</div>
                    <div class="cs-item">@lang('front.catalog_page.sort_price_asc')</div>
                </div>
            </div>
            <div class="btn btn-mini" filter-toggle>фильтр</div>
        </div>

        <div class="catalog-grid grid-12">
            <div class="sidebar">
                <div class="sb-sort sb-element" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.sort_new')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                    </div>
                    <div class="sb-list" toggle-el style="display: none;" data-display="grid">
                        <div class="sb-item">@lang('front.catalog_page.sort_new')</div>
                        <div class="sb-item active">@lang('front.catalog_page.sort_price_desc')</div>
                        <div class="sb-item">@lang('front.catalog_page.sort_price_asc')</div>
                    </div>
                </div>

                <div class="sb-menu sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.category')</span>
                        <img src="@vite_asset('images/icons/arrow-down.svg')" alt="" class="to-svg icon">
                        <div class="btn btn-mini btn-gray prevent" filter-toggle>@lang('front.close')</div>
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

                <div class="sb-color sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.catalog_page.color')</span>
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
                        <div class="show-more primary a">@lang('front.show_all')</div>
                    </div>
                </div>

                <div class="sb-price sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.price'), ₽</span>
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

                <div class="sb-size sb-element active" toggling>
                    <div class="sb-title mini-title" toggle-click>
                        <span>@lang('front.size')</span>
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
                        <div class="show-more primary a col-full">@lang('front.show_all')</div>
                    </div>
                </div>
                <div class="btns-row">
                    <div class="btn btn-mini">@lang('front.reset')</div>
                    <div class="btn btn-mini btn-gray" filter-toggle>@lang('front.close')</div>
                </div>
            </div>

            <div class="catalog-list grid-3">
                @foreach (range(1, 6) as $i)
                    <div class="catalog-item">
                        <div class="catalog-images-wrapper">
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach (range(1, 3) as $i)
                                        <div class="swiper-slide">
                                            <a href="#" class="prod-image"><img src="/storage/tmp/{{ rand(1, 2) }}.png" alt=""></a>
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
                <div class="catalog-bottom-row col-full">
                    <div class="btn btn-show-more">@lang('front.show_more')</div>
                    <ul class="pagination">
                        <li class="prev disabled">
                            <a href="">
                                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                                <span>Назад</span>
                            </a>
                        </li>
                        <li class="  page-1">
                            <a href="?page=1">1</a>
                        </li>
                        <li class=" page-2 active">
                            <a href="?page=2">2</a>
                        </li>
                        <li class=" page-3">
                            <a href="?page=3">3</a>
                        </li>
                        <li class="dots" aria-disabled="true"><span>...</span></li>
                        <li class=" page-11">
                            <a href="?page=11">9</a>
                        </li>
                        <li class="next ">
                            <a href="?page=2">
                                <span>Следующая</span>
                                <img src="@vite_asset('images/icons/arrow-line-right.svg')" alt="" class="to-svg">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection