<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<section class="page_leader">
    <div class="container">
        <div class="page_way">
            <a class="page_way_link" href="/">Главная</a>
            <span>→</span>
            <a class="page_way_link" href="/brands">Бренды</a>
            <span>→</span>
            <p class="page_way_link"><?=$arResult['NAME']?></p>
        </div>
    </div>
</section>
<?
if ($USER->IsAdmin()){
//    pre($arResult);
}
?>
<section class="categories">
    <div class="container">
        <div class="brand-page_info">
            <div class="brand-page_left">
                <h1 class="title_main"><?=$arResult['NAME']?></h1>
                <div class="brand-page_description">
                    <?=(empty($arResult['DETAIL_TEXT']))?$arResult['PREVIEW_TEXT']:$arResult['DETAIL_TEXT']?>
                </div>
            </div>
            <div class="brand-page_right">
                <img class="brand-page_img" src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
            </div>
        </div>
        <h2 class="title small">Категории товаров <?=$arResult['NAME']?></h2>
        <!--<div class="brand-page_wrapper">
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_1.jpg">
                <div class="categories_info">
                    <div class="categories_name">Аксессуары и элементы декора</div>
                    <div class="categories_amount">1258 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_2.jpg">
                <div class="categories_info">
                    <div class="categories_name">Товары для дома и сада</div>
                    <div class="categories_amount">2140 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_3.jpg">
                <div class="categories_info">
                    <div class="categories_name">Товары для праздника</div>
                    <div class="categories_amount">2140 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_4.jpg">
                <div class="categories_info">
                    <div class="categories_name">Изделия из металла</div>
                    <div class="categories_amount">1440 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_5.jpg">
                <div class="categories_info">
                    <div class="categories_name">Изделия из керамики</div>
                    <div class="categories_amount">1258 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_6.jpg">
                <div class="categories_info">
                    <div class="categories_name">Плетенные изделия</div>
                    <div class="categories_amount">450 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_7.jpg">
                <div class="categories_info">
                    <div class="categories_name">Изделия из пластика</div>
                    <div class="categories_amount">1017 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_8.jpg">
                <div class="categories_info">
                    <div class="categories_name">Изделия из стекла</div>
                    <div class="categories_amount">874 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_9.jpg">
                <div class="categories_info">
                    <div class="categories_name">Игрушки</div>
                    <div class="categories_amount">630 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_10.jpg">
                <div class="categories_info">
                    <div class="categories_name">Деревянные изделия</div>
                    <div class="categories_amount">747 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_11.jpg">
                <div class="categories_info">
                    <div class="categories_name">Искусственные растения</div>
                    <div class="categories_amount">210 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_12.jpg">
                <div class="categories_info">
                    <div class="categories_name">Книги и журналы</div>
                    <div class="categories_amount">450 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_13.jpg">
                <div class="categories_info">
                    <div class="categories_name">Натуральные декоративные материалы</div>
                    <div class="categories_amount">630 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_14.jpg">
                <div class="categories_info">
                    <div class="categories_name">Расходные материалы</div>
                    <div class="categories_amount">1258 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
            <div class="categories_box">
                <img class="categories_img" src="/local/templates/eshop_azalia/img/category_15.jpg">
                <div class="categories_info">
                    <div class="categories_name">Упаковка для цветов и подарков</div>
                    <div class="categories_amount">1258 товаров</div>
                </div>
                <a class="categories_link" href="catalog_level_2.html"></a>
            </div>
        </div>-->
    </div>
</section>

<section id="subscription" class="subscription">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:sender.subscribe",
            ".default",
            array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CONFIRMATION" => "N",
                "HIDE_MAILINGS" => "N",
                "SET_TITLE" => "N",
                "SHOW_HIDDEN" => "N",
                "USER_CONSENT" => "Y",
                "USER_CONSENT_ID" => "1",
                "USER_CONSENT_IS_CHECKED" => "N",
                "USER_CONSENT_IS_LOADED" => "N",
                "USE_PERSONALIZATION" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>
    </div>
</section>
