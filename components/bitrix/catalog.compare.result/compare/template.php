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
use Bitrix\Main\Localization\Loc;
$isAjax = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$isAjax = (
		(isset($_POST['ajax_action']) && $_POST['ajax_action'] == 'Y')
		|| (isset($_POST['compare_result_reload']) && $_POST['compare_result_reload'] == 'Y')
	);
}

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);

?><div class="bx_compare <? echo $templateData['TEMPLATE_CLASS']; ?>" id="bx_catalog_compare_block"><?
if ($isAjax)
{
	$APPLICATION->RestartBuffer();
	?>
    <script>
        $(document).ready(function() {
            var swiper = new Swiper('.compare_slider .swiper-container', {
                slidesPerView: 6,
                slidesPerGroup: 1,
                spaceBetween: 10,
                autoHeight: true,
                navigation: {
                    nextEl: '.compare_slider .swiper-button-next',
                    prevEl: '.compare_slider .swiper-button-prev'
                },
                breakpoints: {
                    1650: {
                        slidesPerView: 4
                    },
                    991: {
                        slidesPerView: 3
                    },
                    650: {
                        slidesPerView: 2
                    },
                    380: {
                        slidesPerView: 1
                    }
                }
            });
        });
    </script>
    <?
}
?>
    <section class="page_leader">
        <div class="container">
            <div class="page_way">
                <a class="page_way_link" href="/">Главная</a>
                <span>→</span>
                <p class="page_way_link">Сравнение товаров</p>
            </div>
            <h1 class="title_main">Сравнение товаров</h1>
        </div>
    </section>
    <section class="compare">
        <div class="container">
            <div class="compare_slider">
                <h2 class="compare_caption">Характеристики</h2>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?foreach($arResult["ITEMS"] as $arElement):
                            if (!$arElement['PREVIEW_PICTURE']) {
                                $arElement['PREVIEW_PICTURE'] = array(
                                    'SRC' => "/local/templates/eshop_azalia/img/no_photo.png",
                                );
                            }
                            $quantity =1;
                            $renewal = 'N';
                            $itInDelay = '';
                            $inBasket = '';
                            $productID = $arElement['ID'];
                            $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
                            if (!$arPrice || count($arPrice) <= 0)
                            {
                                if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $USER->GetUserGroupArray()))
                                {
                                    $quantity = $nearestQuantity;
                                    $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
                                }
                            }
                            $dbDelayItems = CSaleBasket::GetList(
                                array(
                                    "NAME" => "ASC",
                                    "ID" => "ASC"
                                ),
                                array(
                                    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                                    "LID" => SITE_ID,
                                    "PRODUCT_ID" => $productID,
                                    "ORDER_ID" => "NULL"
                                ),
                                false,
                                false,
                                array("PRODUCT_ID", "DELAY","QUANTITY")
                            );
                            while ($arItemsDelay = $dbDelayItems->Fetch()) {
                                if ($arItemsDelay['DELAY'] === 'Y') {
                                    $itInDelay = 'Yes';
                                } else {
                                    $inBasket = 'Yes';
                                }
                            }

                            if ( (in_array($arElement["ID"], $dbDelayItems)) || (!empty($itInDelay)) ) { $wished = ' active'; }else { $wished = '';}
                            if ( (in_array($arElement["ID"], $dbDelayItems)) || (!empty($inBasket)) ) { $basket = ' add'; }else { $basket = '';}
//                            pre($arElement);
                            ?>
                        <div class="swiper-slide">
                            <div class="box">
                                <div class="box_wrapper">
                                    <div class="box_marker">
                                        <div class="box_marker_tooltips"></div>
                                    </div>
                                    <div class="box_favorite<?=$wished?> wish_<?=$arElement['ID']?>" onclick="add_wish(<?=$arElement['ID']?>)"></div>
                                    <div class="box_img_wrapper">
                                        <a class="box_img_link" href="<?=$arElement['DETAIL_PAGE_URL']?>">
                                            <img class="box_img" src="<?=$arElement['PREVIEW_PICTURE']['SRC']?>">
                                        </a>
                                        <a class="box_view" href="javascript:void(0);" onclick="fastView(<?=$arElement['ID']?>)">Быстрый просмотр</a>
                                    </div>
                                    <div class="box_info">
                                        <div class="box_category"><?=CIBlockSection::GetByID($arElement["IBLOCK_SECTION_ID"])->GetNext()['NAME'];?></div>
                                        <a class="box_name" href="<?=$arElement['DETAIL_PAGE_URL']?>"><?=$arElement['NAME']?></a>
                                        <div class="box_extra">
                                            <div class="box_price_wrapper">
                                                <!--<div class="box_price_row">
                                                    <div class="box_price old">1 245 ₽</div>
                                                    <div class="box_stock">-14%</div>
                                                </div>-->
                                                <div class="box_price new"><?=CurrencyFormat($arPrice['DISCOUNT_PRICE'], "RUB");?></div>
                                            </div>
                                            <div class="box_compare active" onclick="CatalogCompareObj.delete('<?=CUtil::JSEscape($arElement['~DELETE_URL'])?>');"></div>
                                            <button class="btn basket<?=$basket?>" onclick="add_basket(<?=$arElement['ID']?>)"></button>
                                        </div>
                                    </div>
                                    <div class="box_amount">Осталось <span class="box_amount_number"><?=($arElement['CATALOG_QUANTITY'] >0)?$arElement['CATALOG_QUANTITY']:0?></span> шт.</div>
                                </div>
                            </div>
                            <div class="compare_box">
                                <?foreach ($arElement['PROPERTIES'] as  $prop):?>
                                <?if ($prop['VALUE'] != 199 || empty($prop['VALUE'])) continue;?>
                                <div class="compare_item">
                                    <div class="compare_name"><?=$prop['NAME']?>:</div>
                                    <div class="compare_value"><?=$prop['VALUE']?></div>
                                </div>
                                <?endforeach;?>
                            </div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
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


    <!--<section class="compare">
        <div class="container">
            <h1 class="catalog-h1">Сравнение товаров</h1>
            <div class="catalog-right compare-block">
                <div class="compare__wrapper">
                    <div class="compare__wrapper__scroll">
                        <div class="compare__wrapper__nav">
                            <div class="compare__wrapper__left"></div>
                            <div class="compare__wrapper__right"></div>
                        </div>
                        <div class="compare_product">
                            <?/*foreach($arResult["ITEMS"] as $arElement){*/?>
                                <div class="product-box">
                                    <div class="product-box_trash"></div>
                                    <div class="product-box_over">
                                        <a class="delitem" onclick="CatalogCompareObj.delete('<?/*=CUtil::JSEscape($arElement['~DELETE_URL'])*/?>');" href="javascript:void(0)"></a>
                                        <div class="product-box_view">
                                            <a href="<?/*=$arElement['DETAIL_PAGE_URL']*/?>" class="product-box_top">
                                                <img src="<?/*=$arElement['PREVIEW_PICTURE']['SRC']*/?>" alt="" class="product-box_img">
                                            </a>
                                            <a href="#" class="product-box_fast-view">быстрый просмотр</a>
                                        </div>
                                        <a href="<?/*=$arElement['DETAIL_PAGE_URL']*/?>" class="product-box_name"><?/*=$arElement['NAME']*/?></a>
                                        <div class="product-box_bottom">
                                            <div class="product-box_left">
                                                <div class="product-box_new"><?/*=$arElement['PRICES']['BASE']['PRINT_VALUE']*/?></div>
                                            </div>
                                            <div class="product-box_right">
                                                <a class="product-box_basket_small" href="<?/*=$arElement["BUY_URL"]*/?>" rel="nofollow"></a>
                                            </div>
                                        </div>
                                        <div class="product-box_hidden">
                                            <div class="product-box_favorite">в избранное</div>
                                        </div>
                                    </div>
                                </div>
                                <?/*}*/?>

                        </div>
                        <ul class="compare_ul">
                            <li class="compare_li">
                                <button class="accordion active">Общие характеристики</button>
                                <div class="panel">
                                    <div class="compare_line">

                                        <?/*foreach($arResult["ITEMS"] as $arElement){*/?>
                                        <div class="compare_property">
                                        <?/*foreach ($arElement['PROPERTIES'] as  $prop){
                                            if (empty($prop['VALUE'])) continue;
                                            if ($prop['ID'] == 46 || $prop['ID'] == 47 || $prop['ID'] == 48 || $prop['ID'] == 81 || $prop['ID'] == 82 || $prop['ID'] == 83 || $prop['ID'] == 84) continue;
                                            */?>
                                                <div class="compare_property__name"><?/*=$prop['NAME']*/?></div>
                                                <div class="compare_property__value"><?/*if(!empty($prop['VALUE'])){echo $prop['VALUE'];}else{echo '-';}*/?></div>
                                        <?/*}*/?>
                                        </div>
                                        <?/*}*/?>

                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>-->





<?
if ($isAjax)
{
	die();
}
?>
</div>
<script type="text/javascript">
	var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block", '<?=CUtil::JSEscape($arResult['~COMPARE_URL_TEMPLATE']); ?>');
</script>