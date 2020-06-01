<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?if($arResult['FINALPRICE'] <10000)header('Location: /personal/cart');?>
<section class="registration">
    <div class="container">
        <h1 class="title_center">Оформление заказа</h1>
        <form id="order_form" class="order_form" onsubmit="buy(this);return false;">
            <div class="order_left">
                <!--<div class="order_user">
                    <div class="order_user_text">Если вы уже делали заказ на нашем сайте, войдите в личный кабинет</div>
                    <a class="order_user_link" href="javascript:void(0);">Войти</a>
                </div>-->
                <div class="order_recipient">
                    <div class="order_recipient_row">
                        <div class="order_caption">Данные получателя</div>
                        <nav class="order_nav">
                            <a class="order_link active" href="#order_individual">физ. лицо </a>
                            <a class="order_link" href="#order_entity">юр.лицо</a>
                        </nav>
                    </div>
                    <div id="order_individual" class="order_box">
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">Имя <span>*</span></div>
                                <input class="order_input" name="user_name" type="text" placeholder="Введите ваше имя" autocomplete="off" required>
                            </div>
                            <div class="order_item">
                                <div class="order_text">Фамилия <span>*</span></div>
                                <input class="order_input" name="user_lastName" type="text" placeholder="Введите вашу фамилию" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">E-mail <span>*</span></div>
                                <input class="order_input" name="user_mail" type="email" placeholder="Укажите ваш E-mail" autocomplete="off" required>
                            </div>
                            <div class="order_item">
                                <div class="order_text">Телефон <span>*</span></div>
                                <input class="order_input phone" name="user_phone" type="text" placeholder="+7 352 555 55 55" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div id="order_entity" class="order_box">
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">Название организации или ИП <span>*</span></div>
                                <input class="order_input" name="name" type="text" placeholder="Введите название организации" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">Юридический адрес <span>*</span></div>
                                <input class="order_input" name="address" type="text" placeholder="Введите ваш адрес" autocomplete="off" >
                            </div>
                        </div>
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">E-mail <span>*</span></div>
                                <input class="order_input" name="email" type="email" placeholder="Укажите ваш E-mail" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">Телефон <span>*</span></div>
                                <input class="order_input phone" name="phone" type="text" placeholder="+7 352 555 55 55" autocomplete="off" >
                            </div>
                        </div>
                        <div class="order_row three">
                            <div class="order_item">
                                <div class="order_text">Банка <span>*</span></div>
                                <input class="order_input" name="bank" type="text" placeholder="Сбербанк России" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">БИК банка <span>*</span></div>
                                <input class="order_input" name="bic" type="text" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">Кор.счет <span>*</span></div>
                                <input class="order_input" name="cor" type="text" autocomplete="off" >
                            </div>
                        </div>
                        <div class="order_row three">
                            <div class="order_item">
                                <div class="order_text">ИНН <span>*</span></div>
                                <input class="order_input" name="inn" type="text" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">КПП <span>*</span></div>
                                <input class="order_input" name="kpp" type="text" autocomplete="off" >
                            </div>
                            <div class="order_item">
                                <div class="order_text">Расчетный счет <span>*</span></div>
                                <input class="order_input" name="check" type="text" autocomplete="off" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order_delivery">
                    <div class="order_delivery_row">
                        <div class="order_caption">Способ получения</div>
                        <a class="order_city" href="javascript:void(0);">Москва и Подмосковье</a>
                    </div>
                    <div class="order_delivery_box">
                        <label class="order_delivery_radio express">
                            <input type="radio" name="delivery" required>
                            <div class="order_delivery_radio_box">
                                <div class="order_delivery_radio_caption">Доставка</div>
                                <div class="order_delivery_radio_description">Доставка с помощью СДЭК</div>
                                <div class="order_delivery_radio_address">Москва, Угрешская, д.2. стр. 146</div>
                                <a class="order_delivery_radio_link" href="javascript:void(0);">Изменить</a>
                            </div>
                        </label>
                        <label class="order_delivery_radio pickup">
                            <input type="radio" name="delivery" required>
                            <div class="order_delivery_radio_box">
                                <div class="order_delivery_radio_caption">Самовывоз</div>
                                <div class="order_delivery_radio_description">5 точек самовывоза</div>
                                <div class="order_delivery_radio_address">г. Москва, п. Сосенское, 22-й км Калужского шоссе, стр. 10</div>
                                <a class="order_delivery_radio_link" href="javascript:void(0);">Изменить</a>
                            </div>
                        </label>
                    </div>
                    <div class="order_express">
                        <div class="order_express_row">
                            <div class="order_express_item">
                                <div class="order_express_text">Улица <span>*</span></div>
                                <input class="order_express_input" name="street" type="text" required>
                            </div>
                            <div class="order_express_item">
                                <div class="order_express_text">Дом <span>*</span></div>
                                <input class="order_express_input" name="house_num" type="text" required>
                            </div>
                            <div class="order_express_item">
                                <div class="order_express_text">Квартира <span>*</span></div>
                                <input class="order_express_input" name="apartment" type="text"  required>
                            </div>
                        </div>
                        <div class="order_express_item">
                            <div class="order_express_text">Комментарий к доставке</div>
                            <textarea class="order_express_comment" name="comment"></textarea>
                        </div>
                    </div>
                    <div class="order_pickup">
                        <div class="order_pickup_box">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва, п. Сосенское, 22-й км Калужского шоссе, стр. 10</div>
                                <div class="order_pickup_underground">
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                    ОПЦ «ФУД СИТИ»<br>
                                    14 вход, пав. 22.001-23.032<br>
                                    Ежедневно: 8:00 - 19:00 </div>
                            </div>
                        </div>
                        <div class="order_pickup_box">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва, п. Сосенское, 22-й км Калужского шоссе, стр. 10</div>
                                <div class="order_pickup_underground">
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                    ОПЦ «ФУД СИТИ»<br>
                                    14 вход, пав. 22.001-23.032<br>
                                    Ежедневно: 8:00 - 19:00 </div>
                            </div>
                        </div>
                        <div class="order_pickup_box">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва, п. Сосенское, 22-й км Калужского шоссе, стр. 10</div>
                                <div class="order_pickup_underground">
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                    <span>Полежаевская</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                    ОПЦ «ФУД СИТИ»<br>
                                    14 вход, пав. 22.001-23.032<br>
                                    Ежедневно: 8:00 - 19:00 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order_payment">
                    <div class="order_caption">Способы оплаты</div>
                    <div class="order_payment_container">
                        <?while($deliv = $arResult['PAY']->GetNext()){?>
                            <label class="order_payment_radio">
                                <input type="radio" name="user_pay" value="<?=$deliv['ID']?>" required>
                                <div class="order_payment_radio_box">
                                    <div class="order_payment_radio_caption"><?=$deliv['NAME']?></div>
                                    <div class="order_payment_radio_description"><?=$deliv['DESCRIPTION']?></div>
                                </div>
                            </label>
                        <?}?>
                    </div>
                </div>
                <div class="order_comment">
                    <a class="order_back" href="/personal/cart/">Вернутся в корзину</a>
                    <textarea class="order_comment_input" name="comment" placeholder="Ваш комментарий к заказу"></textarea>
                </div>
            </div>
            <div class="order_right">
                <div class="basket-page_top">
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption">Информация о заказе</div>
                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Позиции (<?=$arResult['QUANTITY']?>)</div>
                            <div class="basket-page_right_value"><?=CurrencyFormat($arResult['PRICE'], "RUB");?></div>
                        </div>
<!--                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Общий вес</div>
                            <div class="basket-page_right_value">10,53 кг</div>
                        </div>-->
                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Персональная скидка </div>
                            <div class="basket-page_right_value"><?=$arResult['DISCOUNT']?></div>
                        </div>
                    </div>
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption">Доставка</div>
                        <div class="basket-page_right_description">г.Москва, ул.Угрешская д. 2 стр. 146</div>
                        <a class="basket-page_delivery_change" href="javascript:void(0);">Изменить</a>
                    </div>
                    <div class="basket-page_right_row">
                        <div class="basket-page_right_text">Итого к оплате:</div>
                        <div class="basket-page_right_price"><?=$arResult['FINALPRICE']?></div>
                    </div>
                    <button class="order_submit" type="submit" onsubmit="buy(this);return false;">Оформить заказ</button>
                </div>
                <div class="order_label">
                    <label class="subscription_checkbox red">
                        <input type="checkbox" name="confirm" required>
                        <div class="subscription_checkbox_text">Я согласен с политикой конфиденциальности и даю согласие на обработку персональных данных</div>
                    </label>
                </div>
            </div>
        </form>
    </div>
</section>



<!--<section class="order">
    <div class="container">
        <div class="basket-top">
            <div class="basket-top__title basket-top__hidden">Ваша корзина</div>
            <div class="basket-top__title">Оформление заказа</div>
        </div>
        <div class="grid order-grid">
            <form id="order_form" class="order__form">
                <div class="order__form_title">Контактные данные</div>
                <div class="grid grid-wrap">
                    <label for="" class="order__form_label">
                        <span class="order__form_span">Имя</span>
                        <input type="text" name="user_name" value="<?/*=$arUser["NAME"]*/?>" class="order__form_input" required>
                    </label>
                    <label for="" class="order__form_label">
                        <span class="order__form_span">Фамилия</span>
                        <input type="text" name="user_lastName" value="<?/*=$arUser["LAST_NAME"]*/?>" class="order__form_input">
                    </label>
                    <label for="" class="order__form_label">
                        <span class="order__form_span">Телефон</span>
                        <input type="text" name="user_phone" value="<?/*=$arUser["PERSONAL_PHONE"]*/?>" class="order__form_input" required>
                    </label>
                    <label for="" class="order__form_label">
                        <span class="order__form_span">E-mail</span>
                        <input type="text" name="user_mail" value="<?/*=$arUser["EMAIL"]*/?>" class="order__form_input" required>
                    </label>
                </div>
                <div class="order__form_title">Доставка</div>
                <div class="grid order__form_wrap">
                    <?/* while ($delivery = $allDeliveries->Fetch()) {
                        if ($delivery["ID"] == 3){$checked = "checked";}else{$checked = "";}
                        */?>
                        <label class="radio order__radio" data-price="<?/*= $delivery['PRICE'] */?>"
                               onclick="choise_delivery(this)">
                            <input type="radio" name="user_delivery" <?/*=$checked*/?> value="<?/*=$delivery["ID"]*/?>">
                            <div class="label radio__text">
                                <span class="order__radio_title"><?/*= $delivery['NAME'] */?></span>
                                <span class="order__label_span"><?/*= $delivery['DESCRIPTION'] */?></span>
                            </div>
                        </label>
                    <?/* } */?>
                </div>
                <div class="n_delivery"  style="display: none">
                    <div class="order__form_title">Адрес</div>
                    <label for="" class="order__form_label">
                        <span class="order__form_span">Город</span>
                        <input type="text" name="city" value="<?/*=$arUser["PERSONAL_CITY"]*/?>" class="order__form_input">
                    </label>
                    <label for="" class="order__form_label">
                        <span class="order__form_span">Улица</span>
                        <input type="text" name="street" value="<?/*=$arUser["PERSONAL_STREET"]*/?>" class="order__form_input">
                    </label>
                    <div class="grid grid-wrap">
                        <label for="" class="order__form_label">
                            <span class="order__form_span">Номер дома</span>
                            <input type="text" name="house_num" class="order__form_input">
                        </label>
                        <label for="" class="order__form_label">
                            <span class="order__form_span">Индекс</span>
                            <input type="text" name="house_index" value="<?/*=$arUser["PERSONAL_ZIP"]*/?>" class="order__form_input">
                        </label>
                    </div>
                </div>
                <div class="y_delivery">
                    <div class="order__form_title">Адрес</div>
                    <p class="order__form_text">г. Одинцово, пос. Лесной городок, ул. Школьная, д. 1 (2 этаж)</p>
                </div>
                <div class="order__form_title">Оплата</div>
                <div class="grid order__form_wrap">
                    <?/*
                        while ($arPaySystemItem = $resPaySystem->Fetch()) {
                            if ($arPaySystemItem["ID"] == 1){$checked = "checked";}else{$checked = "";}
                            */?>
                            <label class="radio order__radio" data-pay="<?/*= $arPaySystemItem['ID'] */?>">
                                <input type="radio" name="user_pay" <?/*=$checked*/?> value="<?/*= $arPaySystemItem['ID'] */?>">
                                <div class="label radio__text">
                                    <span class="order__radio_title"><?/*= $arPaySystemItem["NAME"] */?></span>
                                    <span class="order__label_span"><?/*= $arPaySystemItem["DESCRIPTION"] */?></span>
                                </div>
                            </label>
                        <?/* } */?>
                </div>
                <label for="" class="order__form_label">
                    <span class="order__form_span__text">Комнтарий к заказу</span>
                    <textarea name="" id="comment" cols="30" rows="10" class="order__form_textarea"></textarea>
                </label>
            </form>
            <div class="order__right">
                <p class="order__right_title">Ваш заказ</p>
                <p class="order__right_text">Товары</p>
                <div class="order__right_product">
                    <?/*
                        $allSumm = 0;
                        $average = array();
                        $discount = 0;
                        foreach ($basket as $item) {
                            if ($item->isDelay()) continue;
                            $basketItemsCount++;
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
                            */?>
                            <div class="grid order__right_product__line">
                                <div class="order__right_product__number"><?/*= $basketItemsCount */?></div>
                                <div class="order__right_product__name"><?/*= $item->getField('NAME') */?></div>
                                <div class="order__right_product__count"><?/*= $item->getQuantity() */?>шт
                                </div>
                                <div class="order__right_product__price"><?/*= CurrencyFormat(($arPrice["DISCOUNT_PRICE"] * $item->getQuantity()), "RUB") */?></div>
                            </div>
                            <?/*
                            $allSumm += ($arPrice["DISCOUNT_PRICE"] * $item->getQuantity());
                            $average[] = $arPrice["RESULT_PRICE"]["PERCENT"];
                            $discount += $arPrice["RESULT_PRICE"]["DISCOUNT"];
                        }

                        $average = array_unique($average);
                        $persentAverage = 0;
                        foreach ($average as $aver) {
                            $persentAverage += $aver;
                        }
                        $persentAverage = $persentAverage / count($average);
                    */?>

                </div>
                <p class="order__right_text">Доставка</p>
                <div class="flex justify-content-between order__right_border order__right_flex">
                    <div class="order__right_small" id="delivery_choise">Самовывоз</div>
                    <div class="order__right_value" id="delivery_choise_val">0 ₽</div>
                </div>
                <?/*if($persentAverage > 0):*/?>
                    <p class="order__right_text">Скидка</p>
                    <div class="flex justify-content-between order__right_border order__right_flex">
                        <div class="order__right_small">Скидка <?/*= $persentAverage."%" */?></div>
                        <div class="order__right_value"><?/*= CurrencyFormat($discount, "RUB") */?></div>
                    </div>
                <?/*endif;*/?>
                <div class="flex justify-content-between order__right_flex order__right_end">
                    <div class="order__right_med">Общая сумма</div>
                    <div class="order__right_med_value" id="order_summ"
                         data-all_summ="<?/*= $allSumm */?>"><?/*= CurrencyFormat($allSumm, "RUB") */?></div>
                </div>
                <?/*if($allSumm > 0):*/?>
                    <div class="order__right_product__oform">
                        <a href="javascript:void(0);" class="order__right_product__end"
                           onclick="buy();return false;">Оформить заказ</a>
                    </div>
                <?/*endif;*/?>
            </div>
        </div>
    </div>
</section>-->

<script>
    function choise_delivery(e) {
        $("#delivery_choise").text($(e).find(".order__radio_title").text());
        $("#delivery_choise_val").text($(e).data("price") + " ₽");
        var all_sum = $("#order_summ").data("all_summ");
        var delivery = $(e).data("price");
        var total_summ = all_sum + delivery;
        $("#order_summ").attr('data-all_summ', total_summ);
        var str = String(total_summ);
        var normal_view = str.replace(/(\d)(?=(\d{3})+(\D|$))/g, '$1 ');
        $("#order_summ").text(normal_view + " ₽");
        if (delivery == 0) {
            $(".n_delivery").css({'display': 'none'});
            $(".y_delivery").css({'display': 'block'});
        }else {
            $(".n_delivery").css({'display': 'block'});
            $(".y_delivery").css({'display': 'none'});
        }
    }

    function choise_pay() {

    }

    function buy(e) {
        BX.ajax({
            url: '<?=$templateFolder . '/ajax/result.php';?>',
            method: 'POST',
            dataType: 'html',
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            data: $(e).serialize(),
            onsuccess: function (data) {
                // $('.basket__left').html(data);
                $('#order_form').html(data);
                // console.log(data)
            },
            onfailure: function () {

            }
        });
    }
</script>
