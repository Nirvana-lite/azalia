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
            <a class="catalog_view_item block active" href="<?= $APPLICATION->GetCurPageParam("ch=1",array('ch'))?>"></a>
            <a class="catalog_view_item row" href="<?= $APPLICATION->GetCurPageParam("ch=2",array('ch'))?>"></a>
            <a class="catalog_view_item list" href="<?= $APPLICATION->GetCurPageParam("ch=3",array('ch'))?>"></a>
        </div>
        <div class="catalog_show">Товары: <?=$x_result->num_rows?> из <?= $arResult['NAV_RESULT']->NavRecordCount?></div>
        <?if($arParams["DISPLAY_TOP_PAGER"]):?>
            <?=$arResult["NAV_STRING"]?>
        <?endif;?>
    </div>
<div class="catalog_list">
    <?

    ?>
    <?foreach($arResult["ITEMS"] as $cell=>$arElement):?>
        <? $APPLICATION->IncludeComponent(
            "nirvana:item",
            ".default",
            Array(
                "ITEM_ID" => $arElement['ID'],
                "IBLOCK_ID" => 13
            ),
            false
        );
        ?>
    <?endforeach;?>
</div>
<div class="catalog_row">
    <?if($arParams["DISPLAY_TOP_PAGER"]):?>
        <?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>