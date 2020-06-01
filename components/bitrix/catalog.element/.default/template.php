<?
$iblockid = $arResult['IBLOCK_ID'];
if (isset($_SESSION["CATALOG_COMPARE_LIST"][$iblockid]["ITEMS"][$arResult['ID']])) {
    $checked = ' active';
} else {
    $checked = '';
}
$quantity =1;
    $renewal = 'N';
    $productID = $arResult['ID'];
    $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
    if (!$arPrice || count($arPrice) <= 0)
    {
        if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $USER->GetUserGroupArray()))
        {
            $quantity = $nearestQuantity;
            $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
        }
    }

    ?>
<?
$itInBasket = '';
$itInDelay = '';
$itQuant = 0;
$inBasket = '';
$dbDelayItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "PRODUCT_ID" => $arResult['ID'],
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
$db_props = CIBlockElement::GetProperty(13, $arResult["ID"], array(), Array("ID" => 178));
if ($ar_props = $db_props->Fetch()) {
    switch ($ar_props["VALUE"]) {
        case 164:
            $arResult["MARKER"] = ' fire';
            break;
        case 165:
            $arResult["MARKER"] = ' star';
            break;
        case 166:
            $arResult["MARKER"] = ' new';
            break;
        case 167:
            $arResult["MARKER"] = ' sale';
            break;
        default:
            $arResult["MARKER"] = '';
    }
}
if ( (in_array($arResult["ID"], $dbDelayItems)) || (!empty($itInDelay)) ) { $wished = ' active'; }else { $wished = '';}
if ( (in_array($arResult["ID"], $dbDelayItems)) || (!empty($inBasket)) ) { $basket = ' add'; }else { $basket = '';}
if (!$arResult['DETAIL_PICTURE']['SRC']) {
    $arResult['DETAIL_PICTURE'] = array(
        'SRC' => $templateFolder."/images/no_photo.png",
    );
}
?>
<section class="page_leader">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:breadcrumb",
            "bread",
            Array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0"
            )
        );?>
    </div>
</section>
<section class="card-product">
    <div class="container">
        <div class="card-product_wrapper">
            <div class="card-product_slider">
                <div class="box_marker<?=$arResult["MARKER"]?>">
                    <div class="box_marker_tooltips"></div>
                </div>
                <div class="swiper-container gallery-top">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
                        </div>
<!--                        <div class="swiper-slide">-->
<!--                            <img src="./img/card-product-01.jpg">-->
<!--                        </div>-->
<!--                        <div class="swiper-slide">-->
<!--                            <img src="./img/card-product-01.jpg">-->
<!--                        </div>-->                    </div>

                </div>
                <div class="swiper-container gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>">
                        </div>
                        <!--<div class="swiper-slide">
                            <img src="./img/card-product-01.jpg">
                        </div>
                        <div class="swiper-slide">
                            <img src="./img/card-product-01.jpg">
                        </div>-->
                    </div>
                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="card-product_info">
                <div class="card-product_info_left">
                    <h1 class="card-product_title"><?=$arResult["NAME"]?></h1>
                    <div class="card-product_info_row">
                        <div class="card-product_info_code">Артикул <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></div>
                        <div class="card-product_info_code">ШтрихКод <?=$arResult["PROPERTIES"]["CML2_BAR_CODE"]["VALUE"]?></div>
                        <div class="card-product_info_presence<?=($arResult["CATALOG_QUANTITY"] >0)? "": " grey";?>"><?=($arResult["CATALOG_QUANTITY"] >0)? "Есть в наличии": "Скоро появится";?></div>
                    </div>
<!--                    <div class="card-product_price_row">
                        <div class="card-product_price old">3 124 ₽</div>
                        <div class="card-product_stock">-20%</div>
                    </div>-->
                    <div class="card-product_price new"><?=CurrencyFormat($arPrice['DISCOUNT_PRICE'], "RUB");?></div>
                    <div class="card-product_add">
                        <div class="card-product_count">
                            <div class="card-product_minus" onclick="getQuant(this)">-</div>
                            <div class="card-product_amount">1</div>
                            <div class="card-product_plus" onclick="getQuant(this)">+</div>
                        </div>
                        <button class="btn add-red<?=$basket?>" id="item_<?=$arResult['ID']?>" data-quantity="1" onclick="add_basket(<?=$arResult['ID']?>)">Добавить в корзину</button>
                    </div>
                    <div class="card-product_add_extra">
                        <div class="card-product_compare_box">
                            <div class="card-product_compare<?=$checked?> compareid_<?=$arResult['ID']?>" onclick="add_compare(<?=$arResult['ID']?>)"><?=(!$checked)?'Добавить в сравнение':'В сравнении'?></div>
                        </div>
                        <div class="card-product_favorite_box">
                            <div class="card-product_favorite<?=$wished?> wish_<?=$arResult['ID']?>" onclick="add_wish(<?=$arResult['ID']?>)">В избранное</div>
                        </div>
                    </div>
                    <div class="card-product_delivery">
                        <div class="card-product_delivery_row">Стоимость доставки по <div class="card-product_delivery_city">Москве</div> <span> — 450 ₽</span></div>
                        <div class="card-product_delivery_row">Стоимость доставки по России <span>— от 550 ₽</span></div>
                        <div class="card-product_delivery_row">Самовывоз: <span>Бесплатно</span></div>
                        <div class="card-product_delivery_row address">Москва, 1-й Магистральный проезд, д. 12, стр. 1</div>
                    </div>
                </div>
                <div class="card-product_info_right">
                    <div class="card-product_info_right-top">
                    </div>
                    <div class="card-product_info_right-bottom">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>