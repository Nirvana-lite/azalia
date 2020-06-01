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
            <p class="page_way_link"><?=$arResult['NAME']?></p>
        </div>
        <h1 class="title_main"><?=$arResult['NAME']?></h1>
    </div>
</section>
<section class="article-catalog">
    <div class="container">
        <div class="article-catalog_row">
            <nav class="article-catalog_nav">
                <?$arFilter = array('IBLOCK_ID' => 6);
                    $rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter);
                    while ($arSection = $rsSections->GetNext()) {?>
                        <a class="article-catalog_link active" href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
                    <? } ?>
            </nav>
            <nav class="page_nav">
                <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                    <?=$arResult["NAV_STRING"]?>
                <?endif;?>
            </nav>
        </div>
        <div class="article-catalog_wrapper">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="blog_news">
                    <div class="blog_img_wrapper">
                        <img class="blog_img" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
                        <div class="blog_marker"><?=CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"])->GetNext()['NAME']?></div>
                        <div class="blog_type article">Статьи</div>
                        <a class="blog_img_link" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
                    </div>
                    <div class="blog_info">
                        <div class="blog_date"><?=FormatDate("d F Y", MakeTimeStamp($arItem['DATE_CREATE']))?></div>
                        <a class="blog_name" href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a>
                    </div>
                </div>
            <?endforeach;?>

        </div>
        <div class="catalog_row">
            <a class="catalog_more" href="javascript:void(0);">Показать еще</a>
        </div>
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









