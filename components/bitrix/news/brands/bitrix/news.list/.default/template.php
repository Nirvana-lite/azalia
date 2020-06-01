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
            <p class="page_way_link">Бренды</p>
        </div>
        <h1 class="title_main">Бренды</h1>
    </div>
</section>

<section class="brands mobile">
    <div class="container">
        <div class="brands_row">
            <?if($arParams["DISPLAY_TOP_PAGER"]):?>
                <?=$arResult["NAV_STRING"]?>
            <?endif;?>
        </div>
        <div class="brands_wrapper">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="brands_item">
                    <img class="brands_item_img" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
                    <a class="brands_item_link" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
                </div>
            <?endforeach;?>
        </div>
        <!--<div class="catalog_row">
            <a class="catalog_more" href="javascript:void(0);">Показать еще</a>
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