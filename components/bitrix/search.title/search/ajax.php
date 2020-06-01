<?
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
if (CModule::IncludeModule('iblock')) {
    $arFilter = Array("IBLOCK_ID" => IntVal(13), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y","NAME" => "%{$_POST['title']}%");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 5));

    $arFilter = Array("IBLOCK_ID" => IntVal(13), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y","PROPERTY_CML2_BAR_CODE" => "{$_POST['title']}");
    $res1 = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 1));
    if (intval($res->SelectedRowsCount()) >0 ||intval($res1->SelectedRowsCount()) >0 ){
        while ($ob = $res->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            if (!$arFields["PREVIEW_PICTURE"]) {
                $img =  "/local/templates/eshop_azalia/components/bitrix/search.title/search/images/no_photo.png";
            }else{
                $img = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
            }
            ?>

            <div class="header_search_line">
                <div class="header_search_img_wrapper">
                    <img class="header_search_img" src="<?=$img?>">
                </div>
                <div class="header_search_name"><?=$arFields['NAME']?></div>
                <div class="header_search_price_wrapper">
                    <!--<div class="header_search_price_row">
                        <div class="header_search_price old">2 145 ₽</div>
                        <div class="header_search_stock">-30%</div>
                    </div>-->
                    <div class="header_search_price new"><?=CurrencyFormat(CPrice::GetBasePrice($arFields["ID"])["PRICE"], "RUB");?></div>
                </div>
                <a class="header_search_link" href="<?=$arFields['DETAIL_PAGE_URL']?>"></a>
            </div>
            <?
        }
        while ($ob = $res1->GetNextElement()) {
            $arFields = $ob->GetFields();
            $arProps = $ob->GetProperties();
            if (!$arFields["PREVIEW_PICTURE"]) {
                $img =  "/local/templates/eshop_azalia/components/bitrix/search.title/search/images/no_photo.png";
            }else{
                $img = CFile::GetPath($arFields["PREVIEW_PICTURE"]);
            }
            ?>

            <div class="header_search_line">
                <div class="header_search_img_wrapper">
                    <img class="header_search_img" src="<?=$img?>">
                </div>
                <div class="header_search_name"><?=$arFields['NAME']?></div>
                <div class="header_search_price_wrapper">
                    <!--<div class="header_search_price_row">
                        <div class="header_search_price old">2 145 ₽</div>
                        <div class="header_search_stock">-30%</div>
                    </div>-->
                    <div class="header_search_price new"><?=CurrencyFormat(CPrice::GetBasePrice($arFields["ID"])["PRICE"], "RUB");?></div>
                </div>
                <a class="header_search_link" href="<?=$arFields['DETAIL_PAGE_URL']?>"></a>
            </div>
            <?
        }

        ?>
        <div class="header-search__show">
            <a href = "javascript:void(0);" class="header_search_more" onclick="get_res_title()">Показать все результаты</a>
        </div>
    <?} else{?>
        <div class="header_search_result_error">Товар с таким именем не найден</div>
    <?}}?>