<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>



<?
$x_result = $arResult['NAV_RESULT']->result;
?>
    <div class="catalog_top">
        <div class="catalog_sorting">
            <?$APPLICATION->IncludeComponent(
                "codeblogpro:sort.panel",
                "",
                Array(
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "FIELDS_CODE" => array("show_counter", "created"),
                    "IBLOCK_ID" => "13",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SORT_TO_SESSION" => "Y",
                    "ORDER_NAME" => "ORDER",
                    "PRICE_CODE" => array("2"),
                    "PROPERTY_CODE" => array(),
                    "SORT_NAME" => "SORT",
                    "SORT_ORDER" => array("asc", "desc")
                )
            );?>
        </div>
        <div class="catalog_view">
            <a class="catalog_view_item block" href="<?= $APPLICATION->GetCurPageParam("ch=1",array('ch'))?>"></a>
            <a class="catalog_view_item row active" href="<?= $APPLICATION->GetCurPageParam("ch=2",array('ch'))?>"></a>
            <a class="catalog_view_item list" href="<?= $APPLICATION->GetCurPageParam("ch=3",array('ch'))?>"></a>
        </div>
        <div class="catalog_show">Товары: <?=$x_result->num_rows?> из <?= $arResult['NAV_RESULT']->NavRecordCount?></div>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
<div class="catalog_list_displayRow">
    <?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
        <?
        $itInBasket = '';
        $itInDelay = '';
        $inBasket = '';
        $itQuant = 0;
        $id = $arElement['ID'];
        $dbDelayItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "PRODUCT_ID" => $id,
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
        $iblockid = $arElement['IBLOCK_ID'];
        if (isset($_SESSION["CATALOG_COMPARE_LIST"][$iblockid]["ITEMS"][$id])) {
            $checked = ' active';
        } else {
            $checked = '';
        }
        if (!$arElement['PREVIEW_PICTURE']) {
            $arElement['PREVIEW_PICTURE'] = array(
                'SRC' => $templateFolder."/img/no_photo.png",
            );
        }
        $quantity =1;
        $renewal = 'N';
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
        $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
        switch ($arElement['PROPERTIES']['HIT']['VALUE_ENUM_ID'][0]) {
            case 164:
                $marker = ' fire';
                break;
            case 165:
                $marker = ' star';
                break;
            case 166:
                $marker = ' new';
                break;
            case 167:
                $marker = ' sale';
                break;
            default:
                $marker = '';
        }
        ?>
        <div class="box" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
            <div class="box_wrapper_row">
                <div class="box_marker_row <?=$marker?>">
                    <div class="box_marker_tooltips"></div>
                </div>
                <div class="box_img_wrapper_row">
                    <a class="box_img_link" href="<?=$arElement["DETAIL_PAGE_URL"]?>">
                        <img class="box_img" src="<?=$arElement["PREVIEW_PICTURE"]["SRC"]?>">
                    </a>
                    <a class="box_view" href="javascript:void(0);" onclick="fastView(<?=$arElement['ID']?>)">Быстрый просмотр</a>
                </div>
                <div class="box_info">
                    <div class="box_category"><?=CIBlockSection::GetByID($arElement["IBLOCK_SECTION_ID"])->GetNext()['NAME'];?></div>
                    <a class="box_name" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
                    <div class="box_info_item">
                        <div class="box_info_name">Артикул:</div>
                        <div class="box_info_value"><?=$arElement['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
                    </div>
                </div>
                <div class="card-product_info_presence<?=($arElement["CATALOG_QUANTITY"]>0)?'':' grey'?>"><?=($arElement["CATALOG_QUANTITY"]>0)?'Есть в наличии':'Скоро появится'?></div>
                <div class="box_price_wrapper_row">
                    <!--<div class="box_price_row">
                        <div class="box_price old">3 210 ₽</div>
                        <div class="box_stock">-20%</div>
                    </div>-->
                    <div class="box_price new"><?=CurrencyFormat($arPrice['DISCOUNT_PRICE'], "RUB");?></div>
                </div>
                <div class="box_more_wrapper_row">
                    <div class="box_compare<?=$checked?> compareid_<?=$arElement['ID']?>" onclick="add_compare(<?=$arElement['ID']?>)"></div>
                    <div class="box_favorite_row<?=$wished?> wish_<?=$arElement['ID']?>" onclick="add_wish(<?=$arElement['ID']?>)"></div>
                    <button class="btn basket<?=$basket?>" onclick="add_basket(<?=$arElement['ID']?>)"></button>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>