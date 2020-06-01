<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
if ($basket->getPrice() > 0) {
    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();
    $result = $discounts->getApplyResult(true);
}
?>

<section class="page_leader">
    <div class="container">
        <div class="page_way">
            <a class="page_way_link" href="/">Главная</a>
            <span>→</span>
            <p class="page_way_link">Корзина товаров</p>
        </div>
    </div>
</section>

<section class="basket-page">
    <div class="container">
        <div class="basket-page_wrapper">
            <div class="basket-page_left">
                <div class="basket-page_nav_row">
                    <nav class="basket-page_nav">
                        <a class="basket-page_nav_link active" href="javascript:void(0);">Корзина товаров</a>
                        <a class="basket-page_nav_link" href="/personal/favorite/">Избранные товары</a>
                    </nav>
                    <div class="basket-page_reset" onclick="clear_basket();return false;">Очистить корзину</div>
                </div>
                <ul class="basket-page_list">
                    <?
                    $allSumm = 0;
                    $itemQuantity = 0;
                    $basketItemsCount = 0;
                    $itemWeight = 0;
                    $allDiscont = 0;
                    $defSumm = 0;
                    foreach ($basket as $item) {
                        $basketCode = $item->getBasketCode();
                        if (isset($result['PRICES']['BASKET'][$basketCode])) {
                            $price = $result['PRICES']['BASKET'][$basketCode]['PRICE'] * $item->getQuantity();
                            $allDiscont += $result['PRICES']['BASKET'][$basketCode]['DISCOUNT'] * $item->getQuantity();
                        } else {
                            $price = $item->getPrice() * $item->getQuantity();
                        }
                        $defSumm += $item->getPrice() * $item->getQuantity();
                        $res = GetIBlockElement($item->getProductId());
                        $basketItemsCount++;
                        $quantity = $item->getQuantity();
                        $allSumm += $price;
                        $itemQuantity += $item->getQuantity();
                        if (!$res['PREVIEW_PICTURE']) {
                            $img = $templateFolder . "/img/no_photo.png";
                        } else {
                            $img = CFile::GetPath($res['PREVIEW_PICTURE']);
                        }
                        ?>
                        <li class="basket-page_item" id="basketItem_<?= $item->getProductId(); ?>">
                            <div class="basket-page_img_wrapper">
                                <a class="basket-page_img_link" href="<?= $res["DETAIL_PAGE_URL"] ?>">
                                    <img class="basket-page_img" src="<?= $img ?>">
                                </a>
                            </div>
                            <div class="basket-page_info">
                                <a class="basket-page_info_caption"
                                   href="<?= $res["DETAIL_PAGE_URL"] ?>"><?= $item->getField('NAME') ?></a>
                                <div class="basket-page_info_item">
                                    <div class="basket-page_info_name">Артикул:</div>
                                    <div class="basket-page_info_value"><?= $res["PROPERTIES"]["CML2_ARTICLE"]["VALUE"] ?></div>
                                </div>
                            </div>

                            <div class="basket-page_count">
                                <div class="basket-page_minus"
                                     onclick="quantity('<?= $item->getProductId() ?>','minus')">-
                                </div>
                                <div class="basket-page_amount"
                                     id="i<?= $item->getProductId(); ?>"><?= $item->getQuantity() ?></div>
                                <div class="basket-page_plus" onclick="quantity('<?= $item->getProductId() ?>','plus')">
                                    +
                                </div>
                            </div>
                            <div class="basket-page_price_box">
                                <?
                                if ($allDiscont > 0): ?>
                                    <div class="basket-page_price old" id="old<?=$item->getProductId()?>"><?= CurrencyFormat($item->getPrice() * $item->getQuantity(), "RUB") ?></div>
                                <?endif; ?>
                                <div class="basket-page_price new"
                                     id="p<?= $item->getProductId(); ?>"><?= CurrencyFormat($price, "RUB") ?></div>
                            </div>
                            <div class="basket-page_close" onclick="delItem(<?= $item->getProductId(); ?>)"></div>
                            <div class="basket-page_favorite"></div>
                        </li>
                        <?
                    }
                    ?>
                </ul>

                <form class="basket-page_promo">
                    <div class="basket-page_promo_text">Используйте промокоды и купоны, чтобы получить дополнительную
                        скидку
                    </div>
                    <div class="basket-page_promo_box">
                        <input class="basket-page_promo_input" name="code" type="text" placeholder="Введите промокод"
                               autocomplete="off" required>
                        <button class="basket-page_promo_request" type="submit">Применить</button>
                    </div>
                </form>

            </div>
            <div class="basket-page_right">
                <div class="basket-page_top">
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption">Информация о заказе</div>
                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Позиции (<?= $basketItemsCount ?>)</div>
                            <div class="basket-page_right_value" id="all"><?= CurrencyFormat($defSumm, "RUB") ?></div>
                        </div>
                        <? if ($allDiscont > 0): ?>
                            <div class="basket-page_right_item">
                                <div class="basket-page_right_name">Персональная скидка</div>
                                <div class="basket-page_right_value" id="discont"><?= CurrencyFormat($allDiscont, "RUB") ?></div>
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption">Доставка</div>
                        <div class="basket-page_right_description">г.Москва, ул.Угрешская д. 2 стр. 146</div>
                        <a class="basket-page_deliveryProfit_change" href="javascript:void(0);">Изменить</a>
                    </div>
                    <div class="basket-page_right_row">
                        <div class="basket-page_right_text">Итого к оплате:</div>
                        <div class="basket-page_right_price" id="total"><?= CurrencyFormat($allSumm, "RUB") ?></div>
                    </div>
                    <? if ($allSumm > 10000): ?>
                        <a class="basket-page_order" href="/personal/order/">Оформить заказ</a>
                    <? else: ?>
                        <div class="basket-page_error">
                            <div class="basket-page_error_info">Минимальная сумма заказа 10 000 ₽</div>
                            <div class="basket-page_error_text">Добавьте еще товаров в корзину</div>
                        </div>
                    <? endif; ?>
                </div>
                <div class="basket-page_bottom">
                    <div class="basket-page_advantage deliveryProfit">
                        <div class="basket-page_advantage_text"><a class="advantage_link" href="javascript:void(0);">Доставка</a>
                            по всей россии
                        </div>
                    </div>
                    <div class="basket-page_advantage payment">
                        <div class="basket-page_advantage_text">Удобные способы <a class="advantage_link"
                                                                                   href="javascript:void(0);">оплаты</a>
                            заказа
                        </div>
                    </div>
                    <div class="basket-page_advantage stock">
                        <div class="basket-page_advantage_text">Регулярные <a class="advantage_link"
                                                                              href="javascript:void(0);">акции</a> и
                            распродажи
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<section id="subscription" class="subscription">
    <div class="container">
        <? $APPLICATION->IncludeComponent(
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
        ); ?>
    </div>
</section>

<script>
    function clear_basket() {
        BX.ajax({
            url: '<?=$templateFolder . '/ajax/clear_basket.php';?>',
            method: 'POST',
            dataType: 'html',
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            onsuccess: function (data) {
                $('.basket__left').html(data);
                basket();
                var url = "<?=$APPLICATION->GetCurUri();?>";
                $(location).attr('href', url);
            },
            onfailure: function () {

            }
        });
    }

    function quantity(p_id, th) {
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
                var itemsId = "#i" + p_id + "";
                var priceId = "#p" + p_id + "";
                var old = "#old" + p_id + "";
                $(itemsId).html(html['quantity']);
                $(priceId).html(html['price']);
                $(old).html(html['oldPrice']);
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
                var delId = "#basketItem_" + data['del'] + "";
                $(delId).remove();
                basket();
            },
            onfailure: function () {

            }
        });
    }
</script>