<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>
<div class="header-city">
    <p class="header-city_text">Ваш город:</p>
    <span id="main_city" class="header-city_name" onclick="open_choise_city();"></span>
</div>
<div class="city-confirmation">
    <p class="city-confirmation__title">Ваш город</p>
    <div class="city-confirmation__town" id="city"></div>
    <div class="grid col-2 city-confirmation__grid">
        <a href="javascript:void(0);" class="city-confirmation__yes" onclick="set_city(this)">Да</a>
        <a href="javascript:void(0);" class="city-confirmation__no" onclick="open_choise_city()">Нет</a>
    </div>
</div>


<div id="city_change" class="modal city-change">
    <div class="modal-wrap">
        <div class="modal-top">
            <div id="close" class="modal-close"></div>
            <p class="city-change__title">Выберите город </p>
            <div class="city-change__ul grid col-3">
                <div class="city-change__block">
                    <ul class="city-change__ul">
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Москва и
                                Область</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Волгоград</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Вологда</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Воронеж</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Екатеринбург</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Казань</a>
                        </li>
                    </ul>
                </div>
                <div class="city-change__block">
                    <ul class="city-change__ul">
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Краснодар</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Красноярск</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Нижний
                                Новгород</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Новосибирск</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Пермь</a>
                        </li>
                    </ul>
                </div>
                <div class="city-change__block">
                    <ul class="city-change__ul">
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Ростов-на-Дону</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Самара</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Санкт-Петербург</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);" class="city-change__link">Уфа</a>
                        </li>
                        <li class="city-change__li">
                            <a href="javascript:void(0);" onclick="set_city(this);"
                               class="city-change__link">Челябинск</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

