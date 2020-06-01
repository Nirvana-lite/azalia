<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
use Bitrix\Sale;
global $USER;
if ($USER->IsAuthorized()) {
    $mainUser = CUser::GetByID($USER->GetID())->Fetch();
}
$allSumm = 0;
$allDiscount = 0;
$basePrice = 0;
$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
$discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
if (isset($discounts)) {
    $discounts->calculate();

    $result = $discounts->getApplyResult(true);

    $prices = $result['PRICES']['BASKET'];
    if (isset($prices)) {
        foreach ($prices as $key => $item) {
            $allSumm += $item['PRICE'];
            $allDiscount += $item['DISCOUNT'];
            $basePrice += $item['BASE_PRICE'];

        }
    }
}

?>
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
                                <input class="order_input" name="user_name" type="text" value="<?=$mainUser['NAME']?>" placeholder="Введите ваше имя"
                                       autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Фамилия <span>*</span></div>
                                <input class="order_input" name="user_lastName" type="text"
                                     value="<?=$mainUser['LAST_NAME']?>"  placeholder="Введите вашу фамилию" autocomplete="off">
                            </div>
                        </div>
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">E-mail <span>*</span></div>
                                <input class="order_input" name="user_mail" type="email"
                                     value="<?=$mainUser['EMAIL']?>"  placeholder="Укажите ваш E-mail" autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Телефон <span>*</span></div>
                                <input class="order_input phone" name="user_phone" type="text"
                                     value="<?=$mainUser['PERSONAL_PHONE']?>"  placeholder="+7 352 555 55 55" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div id="order_entity" class="order_box">
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">Название организации или ИП <span>*</span></div>
                                <input class="order_input" name="name" type="text"
                                       placeholder="Введите название организации" autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Юридический адрес <span>*</span></div>
                                <input class="order_input" name="address" type="text" placeholder="Введите ваш адрес"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="order_row">
                            <div class="order_item">
                                <div class="order_text">E-mail <span>*</span></div>
                                <input class="order_input" name="email" type="email" placeholder="Укажите ваш E-mail"
                                       autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Телефон <span>*</span></div>
                                <input class="order_input phone" name="phone" type="text" placeholder="+7 352 555 55 55"
                                       autocomplete="off">
                            </div>
                        </div>
                        <div class="order_row three">
                            <div class="order_item">
                                <div class="order_text">Банка <span>*</span></div>
                                <input class="order_input" name="bank" type="text" placeholder="Сбербанк России"
                                       autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">БИК банка <span>*</span></div>
                                <input class="order_input" name="bic" type="text" autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Кор.счет <span>*</span></div>
                                <input class="order_input" name="cor" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="order_row three">
                            <div class="order_item">
                                <div class="order_text">ИНН <span>*</span></div>
                                <input class="order_input" name="inn" type="text" autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">КПП <span>*</span></div>
                                <input class="order_input" name="kpp" type="text" autocomplete="off">
                            </div>
                            <div class="order_item">
                                <div class="order_text">Расчетный счет <span>*</span></div>
                                <input class="order_input" name="check" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order_delivery">
                    <div class="order_delivery_row">
                        <div class="order_caption">Способ получения</div>
                        <div class="order_city_wrapper">
                          <a class="order_city" href="javascript:void(0);">Москва и Подмосковье</a>
                          <div class="order_city_list">
                            <div class="order_city_item">Москва и Подмосковье</div>
                            <div class="order_city_item">Санкт-Петербург</div>
                            <div class="order_city_item">Екатеринбург</div>
                            <div class="order_city_item">Новосибирск</div>
                            <div class="order_city_item">Ростов-на-Дону</div>
                            <div class="order_city_item">Нижний Новгород</div>
                            <div class="order_city_item">Уфа</div>
                            <div class="order_city_item">Самара</div>
                            <div class="order_city_item">Саранск</div>
                            <div class="order_city_item">Волгоград</div>
                          </div>
                        </div>
                    </div>
                    <div class="order_delivery_box">
                        <label class="order_delivery_radio express">
                            <input type="radio" value="2" name="delivery">
                            <div class="order_delivery_radio_box">
                                <div class="order_delivery_radio_caption">Доставка</div>
                                <div class="order_delivery_radio_description">Доставка с помощью СДЭК</div>
                                <div class="order_delivery_radio_address"></div>
                                <!--<a class="order_delivery_radio_link" href="javascript:void(0);">Изменить</a>-->
                            </div>
                        </label>
                        <label class="order_delivery_radio pickup">
                            <input type="radio" value="3" name="delivery">
                            <div class="order_delivery_radio_box">
                                <div class="order_delivery_radio_caption">Самовывоз</div>
                                <div class="order_delivery_radio_description">5 точек самовывоза</div>
                                <div class="order_delivery_radio_address">
                                </div>
                                <!--<a class="order_delivery_radio_link" href="javascript:void(0);">Изменить</a>-->
                            </div>
                        </label>
                    </div>
                    <div class="order_express">
                        <div class="order_express_row">
                          <div class="order_express_item">
                            <div class="order_express_text">Город <span>*</span></div>
                            <input class="order_express_input" name="city" type="text">
                          </div>
                            <div class="order_express_item">
                                <div class="order_express_text">Улица <span>*</span></div>
                                <input class="order_express_input" name="street" type="text">
                            </div>
                            <div class="order_express_item">
                                <div class="order_express_text">Дом <span>*</span></div>
                                <input class="order_express_input" name="house_num" type="text">
                            </div>
                            <div class="order_express_item">
                                <div class="order_express_text">Квартира <span>*</span></div>
                                <input class="order_express_input" name="apartment" type="text">
                            </div>
                        </div>
                        <div class="order_express_item">
                            <div class="order_express_text">Комментарий к доставке</div>
                            <textarea class="order_express_comment" name="comment"></textarea>
                        </div>
                    </div>
                    <div class="order_pickup">
                        <div class="order_pickup_box" onclick="changedelivery(this)">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва, 1-й Магистральный пр-д, 12c1
                                </div>
                                <div class="order_pickup_underground">
                                    <span>Полежаевская</span>
                                    <span>Фили</span>
                                    <span>Улица 1905 года</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                  без выходных<br>
                                  с 7:00 до 23:00
                                </div>
                            </div>
                        </div>
                        <div class="order_pickup_box" onclick="changedelivery(this)">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва: Склад/пункт выдачи товара, ул. Азовская, д.28Бc1
                                </div>
                                <div class="order_pickup_underground">
                                    <span>Севастопольская</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                  Ежедневно: 8:00 - 20:00 ВНИМАНИЕ: По данному адресу находится склад и пункт выдачи товара.
                                </div>
                            </div>
                        </div>
                        <div class="order_pickup_box" onclick="changedelivery(this)">
                            <div class="order_pickup_left">
                                <div class="order_pickup_caption">г. Москва, 1-й Вешняковский пр-д, 2А
                                </div>
                                <div class="order_pickup_underground">
                                    <span>Рязанский проспект</span>
                                </div>
                            </div>
                            <div class="order_pickup_right">
                                <div class="order_pickup_info">
                                  Ежедневно: 9:00 - 20:00
                                </div>
                            </div>
                        </div>
                      <div class="order_pickup_box" onclick="changedelivery(this)">
                        <div class="order_pickup_left">
                          <div class="order_pickup_caption">г. Москва, п. Сосенское, 22-й км Калужского шоссе,
                            стр. 10
                          </div>
                          <div class="order_pickup_underground">
                            <span>Теплый стан</span>
                            <span>Тропарево</span>
                          </div>
                        </div>
                        <div class="order_pickup_right">
                          <div class="order_pickup_info">
                            ОПЦ «ФУД СИТИ»<br>
                            14 вход, пав. 22.001-23.032<br>
                            Ежедневно: 8:00 - 19:00
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="order_payment">
                    <div class="order_caption">Способы оплаты</div>
                    <div class="order_payment_container">
                        <? while ($deliv = $arResult['PAY']->GetNext()) { ?>
                            <label class="order_payment_radio">
                                <input type="radio" name="user_pay" value="<?= $deliv['ID'] ?>" required>
                                <div class="order_payment_radio_box">
                                    <div class="order_payment_radio_caption"><?= $deliv['NAME'] ?></div>
                                    <div class="order_payment_radio_description"><?= $deliv['DESCRIPTION'] ?></div>
                                </div>
                            </label>
                        <? } ?>
                    </div>
                </div>
                <div class="order_comment">
                    <a class="order_back" href="/personal/cart/">Вернутся в корзину</a>
                    <textarea class="order_comment_input" name="comment"
                              placeholder="Ваш комментарий к заказу"></textarea>
                </div>
            </div>
            <div class="order_right">
                <div class="basket-page_top">
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption">Информация о заказе</div>
                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Позиции (<?= count($result['PRICES']['BASKET']) ?>)
                            </div>
                            <div class="basket-page_right_value"><?= CurrencyFormat($basePrice, "RUB"); ?></div>
                        </div>
                        <!--                        <div class="basket-page_right_item">
                                                    <div class="basket-page_right_name">Общий вес</div>
                                                    <div class="basket-page_right_value">10,53 кг</div>
                                                </div>-->
                        <div class="basket-page_right_item">
                            <div class="basket-page_right_name">Персональная скидка</div>
                            <div class="basket-page_right_value"><?= CurrencyFormat($allDiscount, "RUB"); ?></div>
                        </div>
                    </div>
                    <div class="basket-page_right_box">
                        <div class="basket-page_right_caption value">Доставка</div>
                        <div class="basket-page_right_description value" id="deliveryValue">г.Москва, ул.Угрешская д. 2 стр. 146</div>
                        <a class="basket-page_deliveryProfit_change" href="javascript:void(0);">Изменить</a>
                    </div>
                    <div class="basket-page_right_row">
                        <div class="basket-page_right_text">Итого к оплате:</div>
                        <div class="basket-page_right_price"><?= CurrencyFormat($allSumm, "RUB"); ?></div>
                    </div>
                    <button class="order_submit" type="submit">Оформить заказ
                    </button>
                </div>
                <div class="order_label">
                    <label class="subscription_checkbox red">
                        <input type="checkbox" name="confirm" required>
                        <div class="subscription_checkbox_text">Я согласен с политикой конфиденциальности и даю согласие
                            на обработку персональных данных
                        </div>
                    </label>
                </div>
            </div>
        </form>
    </div>
</section>

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
        } else {
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

                 console.log(data)
            },
            onfailure: function () {

            }
        });
    }
</script>
