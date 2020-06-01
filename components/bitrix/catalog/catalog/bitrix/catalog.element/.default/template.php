<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$id = $arResult['ID'];
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
    array("PRODUCT_ID", "DELAY")
);
while ($arItemsDelay = $dbDelayItems->Fetch()) {
    if ($arItemsDelay['DELAY'] === 'Y') {
        $itInDelay = 'Yes';
    } else {
        $itInBasket = $arItemsDelay['PRODUCT_ID'];
    }
}

if ( (in_array($arResult["ID"], $dbDelayItems)) || (isset($itInDelay)) ) { $wished = 'in_wishlist'; }else { $wished = '';}

$iblockid = $arResult['IBLOCK_ID'];
if (isset($_SESSION["CATALOG_COMPARE_LIST"][$iblockid]["ITEMS"][$id])) {
    $checked = 'checked';
} else {
    $checked = '';
}
?>
<script>
    function add2wish(p_id, pp_id, p, name, dpu, th){
        $.ajax({
            type: "POST",
            url: "/bitrix/templates/eshop_bootstrap_yellow/ajax/wishlist.php",
            data: "p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
            success: function(html){
                $(th).addClass('in_wishlist');
                $('#wishcount').html(html);
            }
        });
    };
</script>
<?
/*echo "<pre>";
print_r($dbDelayItems);
echo "</pre>";*/
?>
<section class="detail">
    <div class="container">
        <div class="grid detail-grid">
            <?
            
            ?>
            <div class="detail-left">
                <div class="detail-left__hash">
                    <a href="#zero" class="detail-left__hash-link active">
                        <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__hash-img">
                    </a>
                    <? if (!empty($arResult['PROPERTIES']['ATT_add_image_1']['VALUE'])){?>
                    <a href="#two" class="detail-left__hash-link">
                        <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_1']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__hash-img">
                    </a>
                    <?}?>
                    <? if (!empty($arResult['PROPERTIES']['ATT_add_image_2']['VALUE'])){ ?>
                    <a href="#free" class="detail-left__hash-link">
                        <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_2']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__hash-img">
                    </a>
                    <?}?>
                    <? if (!empty($arResult['PROPERTIES']['ATT_add_image_3']['VALUE'])){?>
                    <a href="#four" class="detail-left__hash-link">
                        <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_3']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__hash-img">
                    </a>
                    <?}?>
                </div>
                <div class="detail-left__slider">
                    <div class="owl-carousel owl-theme">
                        <div class="item" data-hash="zero">
                            <img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__slider-img">
                        </div>
                        <? if (!empty($arResult['PROPERTIES']['ATT_add_image_1']['VALUE'])){?>
                        <div class="item" data-hash="two">
                            <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_1']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__slider-img">
                        </div>
                        <?}?>
                        <? if (!empty($arResult['PROPERTIES']['ATT_add_image_2']['VALUE'])){ ?>
                        <div class="item" data-hash="free">
                            <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_2']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__slider-img">
                        </div>
                        <?}?>
                        <? if (!empty($arResult['PROPERTIES']['ATT_add_image_3']['VALUE'])){ ?>
                        <div class="item" data-hash="four">
                            <img src="<?=CFile::GetPath($arResult['PROPERTIES']['ATT_add_image_3']['VALUE'])?>" alt="<?= $arResult["NAME"] ?>" title="<?= $arResult["NAME"] ?>" class="detail-left__slider-img">
                        </div>
                        <?}?>
                    </div>
                </div>
            </div>
            <div class="detail-right">
                <div class="detail-right__top">
                    <h1 class="detail-right__name"><?= $arResult["NAME"] ?></h1>
                    <div class="detail-right__star"></div>
                </div>
                <div class="detail-right__do">
                    <?
                    if ($arResult['PROPERTIES']['ATT_old_price']['VALUE'] >0){
                    ?>
                    <div class="detail-right__old"><?=number_format($arResult['PROPERTIES']['ATT_old_price']['VALUE'], 0, '', ' ');?> ₽</div>
                    <?}?>
                    <div class="grid detail-right__grid">
                        <div class="detail-right__do_left">
                            <div class="detail-right__price"><?=number_format($arResult['PRICES']['BASE']['VALUE'], 0, '', ' ');?> <span class="detail-right__price_p">₽</span></div>
                            <?
                            if ($arResult['PROPERTIES']['ATT_old_price']['VALUE'] >0){
                                $discount = $arResult['PROPERTIES']['ATT_old_price']['VALUE'] - $arResult['PRICES']['BASE']['VALUE'];
                            ?>
                            <div class="detail-right__discount">скидка: <?= number_format($discount, 0, '', ' ');?> ₽</div>
                            <?}?>
                        </div>
                        <div class="detail-right__do_right">
                            <form action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" class="add_form">
                                <input type="hidden" name="QUANTITY" value="1" id="QUANTITY<?= $arElement['ID'] ?>" />
                                <input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"] ?>" value="BUY">
                                <input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"] ?>" value="<? echo $arResult["ID"] ?>">
                                <label for="" class="detail-right__add_label">
                                    <input type="submit" class="detail-right__add" name="<? echo $arParams["ACTION_VARIABLE"] . "ADD2BASKET" ?>" <? if (isset($itInBasket)) { ?>value="В корзине" <? } else { ?>value="Добавить в корзину"<? } ?> onclick="if (this.value == 'Добавить в корзину') this.value = 'В корзине';"
                                />
                                </label>
                            </form>
                            <button class="detail-right__click" onclick="buyoneclick(<?= $arResult['ID'] ?>)">Заказать в один клик</button>
                        </div>
                    </div>
                </div>
                <div class="detail-right__bottom">
                    <div class="detail-right__bottom_grid">
                        <div class="detail-right__bottom_line">
                            <div class="detail-right__bottom__name">Артикул:</div>
                            <div class="detail-right__bottom__value"><?=$arResult['PROPERTIES']['ATT_vendor_code']['VALUE']?></div>
                        </div>
                        <div class="detail-right__bottom_line">
                            <div class="detail-right__bottom__name">Доставка:</div>
                            <?$d = strtotime("+1 day"); ?>
                            <div class="detail-right__bottom__value">возможна с <?=date("d.m", $d);?></div>
                        </div>
                        <?
                        if (!empty($arResult['PROPERTIES']['ATT_garanty']['VALUE'])){
                        ?>
                        <div class="detail-right__bottom_line">
                            <div class="detail-right__bottom__name">Гарантия:</div>
                            <div class="detail-right__bottom__value"><?=$arResult['PROPERTIES']['ATT_garanty']['VALUE']?></div>
                        </div>
                        <?}?>
                        <div class="detail-right__bottom_line">
                            <div class="detail-right__bottom__name">Наличие:</div>
                            <?
                            if ($arResult['PROPERTIES']['ATT_balance']['VALUE'] > 0) {?>
                                <div class="detail-right__bottom__value">Под заказ</div>
                                <?
                            }else{?>
                                <div class="detail-right__bottom__value">В наличии</div>
                            <?}?>
                        </div>
                    </div>


                    <div class="detail__size">
                        <?if (!empty($arResult['PROPERTIES']['ATT_height']['VALUE'])){?>
                            <div class="detail__size_box detail__size_height"><?=$arResult['PROPERTIES']['ATT_height']['VALUE']?> см</div>
                        <?}?>
                        <!--            <div class="detail__size_box detail__size_width">--><?//=$arResult['PROPERTIES']['ATT_width']['VALUE']?><!-- см</div>-->
                        <?if (!empty($arResult['PROPERTIES']['ATT_length']['VALUE'])){?>
                            <div class="detail__size_box detail__size_ob"><?=$arResult['PROPERTIES']['ATT_length']['VALUE']?> см</div>
                        <?}?>
                        <?if (!empty($arResult['PROPERTIES']['ATT_Total_power']['VALUE'])){?>
                            <div class="detail__size_box detail__size_weight"><?=$arResult['PROPERTIES']['ATT_Total_power']['VALUE']?></div>
                        <?}?>
                    </div>
                    <div class="detail__add">
                        <a href="javascript:void(0)"  class="detail_favorite wishbtn <?=$wished?>"
                           onclick="add2wish('<?=$arResult["ID"]?>','<?=$arResult["CATALOG_PRICE_ID_1"]?>','<?=$arResult["CATALOG_PRICE_1"]?>','<?=$arResult["NAME"]?>','<?=$arResult["DETAIL_PAGE_URL"]?>',this)">
                            в избранное
                        </a>
                        <div class="detail_compare"><!--в сравнение
                            <input <?/*=$checked;*/?> type="checkbox" id="compareid_<?/*=$arResult['ID'];*/?>" onchange="compare_tov(<?/*=$arResult['ID'];*/?>);">-->

                            <label class="checkbox">
                                <input <?=$checked;?> type="checkbox" id="compareid_<?=$arResult['ID'];?>" onchange="compare_tov(<?=$arResult['ID'];?>);"/>
                                <div class="checkbox__text">в сравнение</div>
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="tabs_block">
            <div class="tabs_block__hidden">
                <div class="tabs_block__hidden-arrow">
                    <div class="tabs_block__hidden-left"></div>
                    <div class="tabs_block__hidden-right"></div>
                </div>
                <ul class="tabs">
                    <li class="active">Описание товара</li>
                    <li>Характеристики</li>
                    <li>Комплектующие</li>
                    <!--<li>Отзывы</li>-->
                    <li>Коллекция</li>
                </ul>
            </div>
            <div class="box visible">
                <div class="description__title"><?= $arResult["NAME"] ?></div>
                <div class="grid box-grid">
                    <div class="description__left">
                        <div class="description__text">Изумительная модель A5700LM-8BK от итальянской компании Arte
                            Lamp относится к коллекции Pinoccio Black и отлично подойдет для установки на потолок кафе
                            и ресторанов, оформленных в стиле лофт. Подвесная люстра Arte Lamp Pinoccio A5700LM-8BK с
                            конусными плафонами осветит помещение площадью 17.8 кв. м. Производитель Arte Lamp
                            рекомендует использовать для устройства лампы накаливания с цоколем E14. Осветительный
                            прибор произведен с использованием материалов: текстиль, дерево и ткань и может
                            использоваться для натяжного потолка. Основным цветом модели A5700LM-8BK является
                            коричневый. Подвесная люстра Pinoccio A5700LM-8BK продается по цене 39900 руб.
                            Торопитесь сделать заказ в интернет-магазине Рамонта.</div>
                    </div>
                    <div class="description__right">
                        <div class="description__line">
                            <div class="description__line_name">Артикул</div>
                            <div class="description__line_value"><?=$arResult['PROPERTIES']['ATT_vendor_code']['VALUE']?></div>
                        </div>
                        <div class="description__line">
                            <div class="description__line_name">Бренд</div>
                            <div class="description__line_value"><?=$arResult['PROPERTIES']['ATT_brand']['VALUE']?></div>
                        </div>
                        <div class="description__line">
                            <div class="description__line_name">Страна</div>
                            <div class="description__line_value"><?=$arResult['PROPERTIES']['ATT_country']['VALUE']?></div>
                        </div>
                        <div class="description__line">
                            <div class="description__line_name">Коллекция</div>
                            <div class="description__line_value"><?=$arResult['PROPERTIES']['ATT_collection']['VALUE']?></div>
                        </div>
                        <div class="description__line">
                            <div class="description__line_name">Стиль</div>
                            <div class="description__line_value"><?=$arResult['PROPERTIES']['ATT_style']['VALUE']?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <p class="accordion">Общие характеристики</p>
                <? foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                <div class="compare_property">
                    <div class="compare_property__name"><?= $arProperty["NAME"] ?></div>
                    <div class="compare_property__value"><?
                        if (is_array($arProperty["DISPLAY_VALUE"])):
                            echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
                        elseif ($pid == "MANUAL"):
                            ?><a href="<?= $arProperty["VALUE"] ?>"><?= GetMessage("CATALOG_DOWNLOAD") ?></a><?
                        else:
                            echo $arProperty["DISPLAY_VALUE"]; ?>
                        <? endif ?></div>
                </div>
                <? endforeach ?>
            </div>
            <div class="box complect-box">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:catalog.section",
                    "accessories_items",
                    array(
                        "ACTION_VARIABLE" => "action",
                        "ADD_PICT_PROP" => "-",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "ADD_TO_BASKET_ACTION" => "ADD",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "BACKGROUND_IMAGE" => "-",
                        "BASKET_URL" => "/personal/basket.php",
                        "BROWSER_TITLE" => "-",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPATIBLE_MODE" => "Y",
                        "CONVERT_CURRENCY" => "N",
                        "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":{\"1\":{\"CLASS_ID\":\"CondIBProp:2:81\",\"DATA\":{\"logic\":\"Equal\",\"value\":\"Да\"}}}}",
                        "DETAIL_URL" => "",
                        "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_COMPARE" => "N",
                        "DISPLAY_TOP_PAGER" => "N",
                        "ELEMENT_SORT_FIELD" => "sort",
                        "ELEMENT_SORT_FIELD2" => "id",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "ELEMENT_SORT_ORDER2" => "desc",
                        "ENLARGE_PRODUCT" => "STRICT",
                        "FILTER_NAME" => "arrFilter",
                        "HIDE_NOT_AVAILABLE" => "N",
                        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                        "IBLOCK_ID" => "2",
                        "IBLOCK_TYPE" => "catalog",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "LABEL_PROP" => array(
                        ),
                        "LAZY_LOAD" => "N",
                        "LINE_ELEMENT_COUNT" => "3",
                        "LOAD_ON_SCROLL" => "N",
                        "MESSAGE_404" => "",
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                        "MESS_BTN_BUY" => "Купить",
                        "MESS_BTN_DETAIL" => "Подробнее",
                        "MESS_BTN_SUBSCRIBE" => "Подписаться",
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                        "META_DESCRIPTION" => "-",
                        "META_KEYWORDS" => "-",
                        "OFFERS_LIMIT" => "0",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Товары",
                        "PAGE_ELEMENT_COUNT" => "16",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_PROPERTIES" => array(
                        ),
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                        "PRODUCT_SUBSCRIPTION" => "Y",
                        "PROPERTY_CODE" => array(
                            0 => "ATT_vendor_code",
                            1 => "ATT_Types_materials",
                            2 => "ATT_Interior",
                            3 => "ATT_Number_lamps",
                            4 => "ATT_Installation_location",
                            5 => "ATT_Lamp_power",
                            6 => "ATT_Voltage",
                            7 => "ATT_Manufacturer",
                            8 => "ATT_Degree_protection",
                            9 => "ATT_country",
                            10 => "ATT_Scope_application",
                            11 => "ATT_COLOR",
                            12 => "ATT_Color_plafonds",
                            13 => "ATT_STOCK",
                            14 => "ATT_Brand",
                            15 => "ATT_Height",
                            16 => "ATT_Guarantee",
                            17 => "ATT_Depth",
                            18 => "ATT_Diameter",
                            19 => "ATT_Length",
                            20 => "vote_count",
                            21 => "ATT_Collection",
                            22 => "ATT_Lamps_included",
                            23 => "ATT_Material_valve",
                            24 => "ATT_Material_plafonds",
                            25 => "ATT_Availability",
                            26 => "ATT_New",
                            27 => "ATT_general_power",
                            28 => "ATT_Area_I",
                            29 => "rating",
                            30 => "ATT_Light_flow",
                            31 => "ATT_OLD_PRICE",
                            32 => "ATT_STYLE",
                            33 => "vote_sum",
                            34 => "ATT_Type_bulb_D",
                            35 => "ATT_Type_bulb_P",
                            36 => "ATT_Type_socle",
                            37 => "ATT_Shade_shape",
                            38 => "ATT_Color_reinforcement",
                            39 => "ATT_Width",
                            40 => "",
                        ),
                        "PROPERTY_CODE_MOBILE" => array(
                            0 => "ATT_vendor_code",
                            1 => "ATT_Types_materials",
                            2 => "ATT_Interior",
                            3 => "ATT_Number_lamps",
                            4 => "ATT_Installation_location",
                            5 => "ATT_Lamp_power",
                            6 => "ATT_Voltage",
                            7 => "ATT_Manufacturer",
                            8 => "ATT_Degree_protection",
                            9 => "ATT_country",
                            10 => "ATT_Scope_application",
                            11 => "ATT_COLOR",
                            12 => "ATT_Color_plafonds",
                        ),
                        "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                        "RCM_TYPE" => "personal",
                        "SECTION_CODE" => "",
                        "SECTION_ID" => "",
                        "SECTION_ID_VARIABLE" => "SECTION_ID",
                        "SECTION_URL" => "",
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "SEF_MODE" => "N",
                        "SET_BROWSER_TITLE" => "Y",
                        "SET_LAST_MODIFIED" => "Y",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "Y",
                        "SHOW_404" => "N",
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "SHOW_CLOSE_POPUP" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_FROM_SECTION" => "N",
                        "SHOW_MAX_QUANTITY" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_PRICE_COUNT" => "1",
                        "SHOW_SLIDER" => "N",
                        "SLIDER_INTERVAL" => "3000",
                        "SLIDER_PROGRESS" => "N",
                        "TEMPLATE_THEME" => "blue",
                        "USE_ENHANCED_ECOMMERCE" => "N",
                        "USE_MAIN_ELEMENT_SECTION" => "Y",
                        "USE_PRICE_COUNT" => "N",
                        "USE_PRODUCT_QUANTITY" => "N",
                        "COMPONENT_TEMPLATE" => "new_items"
                    ),
                    false
                );?>
            </div>
            <!--<div class="box">
               <div class="comments">
                   <div class="comment-box">
                       <div class="comment-box__top">
                           <div class="comment-box__name">Виктор Терентьев</div>
                           <div class="comment-box__stars"></div>
                           <div class="comment-box__date">23.10.2018</div>
                       </div>
                       <div class="comment-box__text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                           eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                           nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                           irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                           Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit
                           anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                           accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                           veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem
                           quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui
                           ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor
                           sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut
                           labore et dolore magnam aliquam quaerat voluptatem.</div>
                   </div>
               </div>
            </div>-->
            <div class="box collection-box">
                <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "accessories_items",
                array(
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "-",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_SECTIONS_CHAIN" => "N",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "BACKGROUND_IMAGE" => "-",
                "BASKET_URL" => "/personal/basket.php",
                "BROWSER_TITLE" => "-",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPATIBLE_MODE" => "Y",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":{\"1\":{\"CLASS_ID\":\"CondIBProp:2:81\",\"DATA\":{\"logic\":\"Equal\",\"value\":\"Да\"}}}}",
                "DETAIL_URL" => "",
                "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "DISPLAY_COMPARE" => "N",
                "DISPLAY_TOP_PAGER" => "N",
                "ELEMENT_SORT_FIELD" => "sort",
                "ELEMENT_SORT_FIELD2" => "id",
                "ELEMENT_SORT_ORDER" => "asc",
                "ELEMENT_SORT_ORDER2" => "desc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "arrFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "2",
                "IBLOCK_TYPE" => "catalog",
                "INCLUDE_SUBSECTIONS" => "Y",
                "LABEL_PROP" => array(
                ),
                "LAZY_LOAD" => "N",
                "LINE_ELEMENT_COUNT" => "3",
                "LOAD_ON_SCROLL" => "N",
                "MESSAGE_404" => "",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_BTN_SUBSCRIBE" => "Подписаться",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "META_DESCRIPTION" => "-",
                "META_KEYWORDS" => "-",
                "OFFERS_LIMIT" => "0",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                "PAGER_SHOW_ALL" => "N",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_TEMPLATE" => ".default",
                "PAGER_TITLE" => "Товары",
                "PAGE_ELEMENT_COUNT" => "16",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array(
                0 => "BASE",
                ),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPERTIES" => array(
                ),
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE" => array(
                0 => "ATT_vendor_code",
                1 => "ATT_Types_materials",
                2 => "ATT_Interior",
                3 => "ATT_Number_lamps",
                4 => "ATT_Installation_location",
                5 => "ATT_Lamp_power",
                6 => "ATT_Voltage",
                7 => "ATT_Manufacturer",
                8 => "ATT_Degree_protection",
                9 => "ATT_country",
                10 => "ATT_Scope_application",
                11 => "ATT_COLOR",
                12 => "ATT_Color_plafonds",
                13 => "ATT_STOCK",
                14 => "ATT_Brand",
                15 => "ATT_Height",
                16 => "ATT_Guarantee",
                17 => "ATT_Depth",
                18 => "ATT_Diameter",
                19 => "ATT_Length",
                20 => "vote_count",
                21 => "ATT_Collection",
                22 => "ATT_Lamps_included",
                23 => "ATT_Material_valve",
                24 => "ATT_Material_plafonds",
                25 => "ATT_Availability",
                26 => "ATT_New",
                27 => "ATT_general_power",
                28 => "ATT_Area_I",
                29 => "rating",
                30 => "ATT_Light_flow",
                31 => "ATT_OLD_PRICE",
                32 => "ATT_STYLE",
                33 => "vote_sum",
                34 => "ATT_Type_bulb_D",
                35 => "ATT_Type_bulb_P",
                36 => "ATT_Type_socle",
                37 => "ATT_Shade_shape",
                38 => "ATT_Color_reinforcement",
                39 => "ATT_Width",
                40 => "",
                ),
                "PROPERTY_CODE_MOBILE" => array(
                0 => "ATT_vendor_code",
                1 => "ATT_Types_materials",
                2 => "ATT_Interior",
                3 => "ATT_Number_lamps",
                4 => "ATT_Installation_location",
                5 => "ATT_Lamp_power",
                6 => "ATT_Voltage",
                7 => "ATT_Manufacturer",
                8 => "ATT_Degree_protection",
                9 => "ATT_country",
                10 => "ATT_Scope_application",
                11 => "ATT_COLOR",
                12 => "ATT_Color_plafonds",
                ),
                "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                "RCM_TYPE" => "personal",
                "SECTION_CODE" => "",
                "SECTION_ID" => "",
                "SECTION_ID_VARIABLE" => "SECTION_ID",
                "SECTION_URL" => "",
                "SECTION_USER_FIELDS" => array(
                0 => "",
                1 => "",
                ),
                "SEF_MODE" => "N",
                "SET_BROWSER_TITLE" => "Y",
                "SET_LAST_MODIFIED" => "Y",
                "SET_META_DESCRIPTION" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_STATUS_404" => "N",
                "SET_TITLE" => "Y",
                "SHOW_404" => "N",
                "SHOW_ALL_WO_SECTION" => "Y",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_FROM_SECTION" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "N",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_MAIN_ELEMENT_SECTION" => "Y",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "COMPONENT_TEMPLATE" => "new_items"
                ),
                false
                );?>
            </div>
        </div>
    </div>
</section>
