<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
CModule::IncludeModule('iblock');
?>
<section class="page_leader">
    <div class="container">
        <div class="page_way">
            <a class="page_way_link" href="/">Главная</a>
            <span>→</span>
            <p class="page_way_link">Поиск по каталогу</p>
        </div>
        <h1 class="title_main">Результаты поиска</h1>
    </div>
</section>


<? if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>
<? elseif ($arResult["ERROR_CODE"] != 0): ?>
    <section class="search-page_empty">
        <div class="container">
            <div class="search-page_empty_bg"></div>
            <h1 class="search-page_empty_caption">По вашему запросу ничего не найдено</h1>
            <div class="search-page_empty_description">Попробуйте изменить формулировку или воспользуйтесь
                <a class="search-page_empty_link" href="/catalog/">каталогом</a></div>
        </div>
    </section>
<? elseif (count($arResult["SEARCH"]) > 0): ?>
    <? if ($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
    <section class="search-page">
        <div class="container">
            <div class="brands_row">
                <? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
            </div>
            <div class="search-page_wrapper">
                <? foreach ($arResult["SEARCH"] as $arItem): ?>
                    <? $APPLICATION->IncludeComponent(
                        "nirvana:item",
                        ".default",
                        Array(
                            "ITEM_ID" => $arItem['ITEM_ID'],
                            "IBLOCK_ID" => 13
                        ),
                        false
                    ); ?>
                <? endforeach; ?>
            </div>
        </div>
    </section>

<? else: ?>
    <section class="search-page_empty">
        <div class="container">
            <div class="search-page_empty_bg"></div>
            <h1 class="search-page_empty_caption">По вашему запросу ничего не найдено</h1>
            <div class="search-page_empty_description">Попробуйте изменить формулировку или воспользуйтесь
                <a class="search-page_empty_link" href="/catalog/">каталогом</a></div>
        </div>
    </section>
<? endif; ?>


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
</div>