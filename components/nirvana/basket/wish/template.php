<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
CModule::IncludeModule('iblock');
use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

?>
<?
$count = 0;
foreach ($basket as $item) {
    if (!$item->isDelay()) {
        continue;
    }else{
        $count++;
    }
?>
    <?}?>
<section class="page_leader">
    <div class="container">
        <div class="page_way">
            <a class="page_way_link" href="/">Главная</a>
            <span>→</span>
            <p class="page_way_link">Избранные товары</p>
        </div>
    </div>
</section>
<?if($count ==0):?>
<section class="basket-page_empty">
    <div class="container">
        <div class="basket-page_empty_bg"></div>
        <h1 class="basket-page_empty_caption">Список избранных товаров пуст</h1>
        <div class="basket-page_empty_description">У нас есть на что обратить внимание. Желаем приятных покупок!</div>
        <a class="basket-page_empty_link" href="/catalog/">Перейти в каталог</a>
    </div>
</section>
<?else:?>
<section class="favorite">
    <div class="container">
        <div class="favorite_wrapper">
            <div class="basket-page_nav_row">
                <nav class="basket-page_nav">
                    <a class="basket-page_nav_link" href="/personal/cart/">Корзина товаров</a>
                    <a class="basket-page_nav_link active" href="javascript:void(0);">Избранные товары</a>
                </nav>
                <div class="favorite_add">Добавить все в корзину</div>
            </div>
            <ul class="basket-page_list">
                <?
                foreach ($basket as $item) {
                    $res = GetIBlockElement($item->getProductId());

                    if (!$item->isDelay()) continue;
                    $quantity = $item->getQuantity();
                    $productID = $item->getProductId();
                    $renewal = "N";
                    $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
                    if (!$arPrice || count($arPrice) <= 0) {
                        if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($productID, $quantity, $USER->GetUserGroupArray())) {
                            $quantity = $nearestQuantity;
                            $arPrice = CCatalogProduct::GetOptimalPrice($productID, $quantity, $USER->GetUserGroupArray(), $renewal);
                        }
                    }
                    (!$res['PREVIEW_PICTURE'])? $img = $templateFolder . "/img/no_photo.png" : $img = CFile::GetPath($res['PREVIEW_PICTURE']);
                    ?>
                    <li class="favorite_item" id="wishItem_<?=$item->getProductId() ?>">
                        <div class="basket-page_img_wrapper">
                            <a class="basket-page_img_link" href="<?= $res["DETAIL_PAGE_URL"] ?>">
                                <img class="basket-page_img" src="<?= $img ?>">
                            </a>
                        </div>
                        <div class="basket-page_info">
                            <a class="basket-page_info_caption" href="<?= $res["DETAIL_PAGE_URL"] ?>"><?= $item->getField('NAME') ?></a>
                            <div class="basket-page_info_item">
                                <div class="basket-page_info_name">Артикул:</div>
                                <div class="basket-page_info_value"><?= $res["PROPERTIES"]["CML2_ARTICLE"]["VALUE"] ?></div>
                            </div>
                           <!-- <div class="basket-page_info_item">
                                <div class="basket-page_info_name">Вес:</div>
                                <div class="basket-page_info_value">5,75 кг</div>
                            </div>-->
                        </div>
                        <div class="basket-page_count">
                            <div class="basket-page_minus" onclick="quantity('<?= $item->getProductId() ?>','minus')">-</div>
                            <div class="basket-page_amount" id="i<?= $item->getProductId(); ?>"><?= $item->getQuantity() ?></div>
                            <div class="basket-page_plus" onclick="quantity('<?= $item->getProductId() ?>','plus')">+</div>
                        </div>
                        <div class="basket-page_price_box">
<!--                            <div class="basket-page_price old">2 415 ₽</div>-->
                            <div class="basket-page_price new" id="p<?= $item->getProductId(); ?>"><?= CurrencyFormat($arPrice["DISCOUNT_PRICE"]* $item->getQuantity(), "RUB") ?></div>
                        </div>
                        <button class="favorite_basket-add" onclick="add_basket(<?= $item->getProductId(); ?>)">Добавить в корзину</button>
                        <div class="basket-page_close" onclick="delItem(<?= $item->getProductId(); ?>)"></div>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
</section>
<?endif;?>
<?if($count>0):?>
<!--<section id="may-like" class="may-like">
    <div class="container">
        <div class="may-like_slider">
            <h2 class="title small">Рекомендуем к выбранным вами товарам</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-21.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Кувшин</div>
                                    <a class="box_name" href="card_product.html">Кувшин (керамика), Н18.5см, 2л, зеленый</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old">3 415 ₽</div>
                                                <div class="box_stock">-30%</div>
                                            </div>
                                            <div class="box_price new">793 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-22.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Кувшин</div>
                                    <a class="box_name" href="card_product.html">Кувшин (керамика), Н19см, белый/24шт.</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old">2 640 ₽</div>
                                                <div class="box_stock">-30%</div>
                                            </div>
                                            <div class="box_price new">359 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-23.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Колонна</div>
                                    <a class="box_name" href="card_product.html">Колонна (шамот), H90см</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old">7 415 ₽</div>
                                                <div class="box_stock">-30%</div>
                                            </div>
                                            <div class="box_price new">5 830 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-24.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Другие формы</div>
                                    <a class="box_name" href="card_product.html">Декор. изделие Karo (керамика), 16.5см, камень/20шт.</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old"></div>
                                                <div class="box_stock none"></div>
                                            </div>
                                            <div class="box_price new">273 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-25.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Кашпо</div>
                                    <a class="box_name" href="card_product.html">Кашпо (керамика) 12,2х12,2х9,8см, коричневый/36шт.</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old">250 ₽</div>
                                                <div class="box_stock">-30%</div>
                                            </div>
                                            <div class="box_price new">158 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="box">
                            <div class="box_wrapper">
                                <div class="box_marker">
                                    <div class="box_marker_tooltips"></div>
                                </div>
                                <div class="box_favorite"></div>
                                <div class="box_img_wrapper">
                                    <a class="box_img_link" href="card_product.html">
                                        <img class="box_img" src="./img/product-26.jpg">
                                    </a>
                                    <a class="box_view" href="javascript:void(0);" onclick="open_modal('quickViewModal')">Быстрый просмотр</a>
                                </div>
                                <div class="box_info">
                                    <div class="box_category">Кашпо</div>
                                    <a class="box_name" href="card_product.html">Кашпо Амфора коринф (шамот), 22*30см</a>
                                    <div class="box_extra">
                                        <div class="box_price_wrapper">
                                            <div class="box_price_row">
                                                <div class="box_price old"></div>
                                                <div class="box_stock none"></div>
                                            </div>
                                            <div class="box_price new">1 157 ₽</div>
                                        </div>
                                        <div class="box_compare">
                                            <label class="box_compare_checkbox">
                                                <input type="checkbox">
                                                <div class="box_compare_icon"></div>
                                            </label>
                                        </div>
                                        <button class="btn basket" onclick="open_modal('addBasketModal')"></button>
                                    </div>
                                </div>
                                <div class="box_amount">Осталось <span class="box_amount_number">5</span> шт.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           Add Arrows
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>-->
<?endif;?>
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

<script>
    function quantity(p_id, th){
        BX.ajax({
            url: "<?=$templateFolder . '/ajax/quantity.php';?>",
            method: 'POST',
            dataType: 'json',
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            data: "p_id=" + p_id + "&th=" + th,
            onsuccess: function (html) {
                basket();
                var itemsId = "#i"+p_id+"";
                var priceId = "#p"+p_id+"";
                $(itemsId).html(html['quantity']);
                $(priceId).html(html['price']);
                $("#allBasketCount").html(html['all_quantity']+" шт");
            },
            onfailure: function () {
            }
        });
    }
    function delItem(p_id) {
        BX.ajax({
            url: '<?=$templateFolder . '/ajax/delete_item.php';?>',
            method: 'POST',
            dataType: 'json',
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            data: "p_id=" + p_id,
            onsuccess: function (data) {
                var delId = "#wishItem_"+data['del']+"";
                $(delId).remove();
                wish();
            },
            onfailure: function () {

            }
        });
    }
</script>