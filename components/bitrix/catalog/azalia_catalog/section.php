<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
    $this->setFrameMode(true);
?>
<?
?>
<? $APPLICATION->IncludeComponent(
    "bitrix:catalog.section.list",
    "",
    Array(
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "DISPLAY_PANEL" => "N",
        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
        "CACHE_TIME" => $arParams["CACHE_TIME"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
    ),
    $component
); ?>
<?
   CModule::IncludeModule("iblock");
    $arFilter = array(
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    );
    if (strlen($arResult["VARIABLES"]["SECTION_CODE"]) > 0) {
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
    } elseif ($arResult["VARIABLES"]["SECTION_ID"] > 0) {
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    }
    $obCache = new CPHPCache;
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } else {
        $arCurSection = array();
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));
        $dbRes = new CIBlockResult($dbRes);
        if (defined("BX_COMP_MANAGED_CACHE")) {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->GetNext()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
            }
            $CACHE_MANAGER->EndTagCache();
        } else {
            if (!$arCurSection = $dbRes->GetNext()) {
                $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    $arResult['SECTION_ID'] = CIBlockFindTools::GetSectionID(
        $arResult['VARIABLES']['SECTION_ID'],
        $arResult['VARIABLES']['SECTION_CODE'],
        array('IBLOCK_ID' => $arParams['IBLOCK_ID'])
    );
    if (CModule::IncludeModule("iblock")) {
        $arFilter = Array(
            'IBLOCK_ID' => $arParams["IBLOCK_ID"],
            'GLOBAL_ACTIVE' => 'Y',
            'SECTION_ID' => $arResult['SECTION_ID'],
        );
        /*$db_list = CIBlockSection::GetList(Array(), $arFilter, true);
        while ($ar_result = $db_list->GetNext()) {
            $haveSections = $ar_result['IBLOCK_SECTION_ID'];
//            pre($ar_result);
            break;
        }*/
        $arSelect = Array("ID");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), $arSelect);
        while($ob = $res->GetNext())
        {
//            pre($ob["ID"]);
           $viewFilter = $ob["ID"];
        }
    }
    if (isset($viewFilter)) {
        ?>
<section class="catalog">
    <div class="container">
        <div class="catalog_wrapper">
            <div class="catalog_left">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "defaultx",
            array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "SECTION_ID" => $arCurSection['ID'],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "PRICE_CODE" => $arParams["~PRICE_CODE"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SAVE_IN_SESSION" => "N",
                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                "XML_EXPORT" => "N",
                "SECTION_TITLE" => "NAME",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "SECTION_DESCRIPTION" => "DESCRIPTION",
                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                "SEF_MODE" => $arParams["SEF_MODE"],
                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
            ),
            $component,
            array('HIDE_ICONS' => 'Y')
        );?>
            </div>
            <div class="catalog_right">
                <?
                    switch ($_GET['ch']) {
                        case 1:
                            $choise = 'catalog_items';
                            break;
                        case 2:
                            $choise = 'catalog_items_row';
                            break;
                        case 3:
                            $choise = 'catalog_items_line';
                            break;
                        default:
                            $choise = 'catalog_items';
                            break;
                    }
                ?>
<?
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "$choise",
            Array(
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                "BASKET_URL" => $arParams["BASKET_URL"],
                "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                "PRICE_CODE" => $arParams["PRICE_CODE"],
                "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],

                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

                "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
            ),
            $component
        );
  ?>
            </div>
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

        <?}?>


