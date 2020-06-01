<?
    define('NO_KEEP_STATISTIC', true);
    define('NOT_CHECK_PERMISSIONS', true);
    require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php'; ?>
<?
    CModule::IncludeModule('sale');
    CModule::IncludeModule("catalog");

    if ($_POST["user_delivery"] > 0){
        $user_delivery = $_POST["user_delivery"];
    }else{
        $user_delivery = 3;
    }
    if ($_POST["user_pay"] > 0){
        $user_pay = $_POST["user_pay"];
    }else{
        $user_pay = 1;
    }

    if (!CUser::GetID()) {

        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

        $max = 10;
        $size = StrLen($chars) - 1;
        $password = null;
        while ($max--)
            $password .= $chars[rand(0, $size)];
        $mail = $password . '@usr.ru';
        ?>
        <?
        $user = new CUser;
        $arFields = Array(
            "NAME" => $_POST["user_name"],
            "LAST_NAME" => $_POST["user_lastName"],
            "EMAIL" => $_POST["user_mail"],
            "LOGIN" => $_POST["user_phone"],
            "PERSONAL_PHONE" => $_POST["user_phone"],
            "PERSONAL_CITY" => $_POST["city"],
            "PERSONAL_ZIP" => $_POST["house_index"],
            "PERSONAL_STREET" => $_POST["street"] . "  " . $_POST["house_num"]. "  " . $_POST["apartment"],
            "LID" => "ru",
            "ACTIVE" => "Y",
            "GROUP_ID" => array(5),
            "PASSWORD" => $password,
            "CONFIRM_PASSWORD" => $password
        );

        $ID = $user->Add($arFields);
    } else {
        $ID = CUser::GetID();
    }
    if (intval($ID) > 0) {

        $dbBasketItems = CSaleBasket::GetList(
            array(
                "NAME" => "ASC",
                "ID" => "ASC",

            ),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL",
                "DELAY" => "N"
            ),
            false,
            false,
            array("ID", "NAME", "PRICE", "QUANTITY", "PRODUCT_ID", "DISCOUNT_PRICE")
        );
        while ($ob = $dbBasketItems->GetNext()) {
            $products[] = [
                'PRODUCT_ID' => $ob['PRODUCT_ID'],
                'NAME' => $ob['NAME'],
                'PRICE' => $ob['PRICE'],
                'CURRENCY' => 'RUB',
                'QUANTITY' => $ob['QUANTITY']
            ];
        }

        // товары
        $basket = Bitrix\Sale\Basket::create(SITE_ID);

        foreach ($products as $product) {
            $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
            unset($product["PRODUCT_ID"]);
            $item->setFields($product);
        }
        $order = Bitrix\Sale\Order::create(SITE_ID, $ID);
        $order->setPersonTypeId($ID);
        $order->setBasket($basket);
        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem(
            Bitrix\Sale\Delivery\Services\Manager::getObjectById($user_delivery)
        );
        $shipmentItemCollection = $shipment->getShipmentItemCollection();

        foreach ($basket as $basketItem) {
            $item = $shipmentItemCollection->createItem($basketItem);
            $item->setQuantity($basketItem->getQuantity());
        }
        $paymentCollection = $order->getPaymentCollection();
        $payment = $paymentCollection->createItem(
            Bitrix\Sale\PaySystem\Manager::getObjectById($user_pay)
        );
        $payment->setField("SUM", $order->getPrice());
        $payment->setField("CURRENCY", $order->getCurrency());
        $result = $order->save();
        if (!$result->isSuccess()) {
            ?>
            <div class="modal profit active">
                <div class="modal-wrap">
                    <div class="modal-top">
                        <div class="modal-top_up">
                            <div class="modal-close" onclick="fucking_close()"></div>
                        </div>
                        <div class="profit-body">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/profit.jpg" alt="" class="profit-img">
                            <div class="profit-title"><?
                                    $result->getErrors(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?
        } else {
            $res = CSaleBasket::GetList(array(), array(
                'FUSER_ID' => CSaleBasket::GetBasketUserID(),
                'LID' => SITE_ID,
                'ORDER_ID' => 'null',
                'DELAY' => 'N',
                'CAN_BUY' => 'Y'));
            while ($row = $res->fetch()) {
                CSaleBasket::Delete($row['ID']);
            }
            ?>
            <div class="modal profit active">
                <div class="modal-wrap">
                    <div class="modal-top">
                        <div class="modal-top_up">
                            <div class="modal-close" onclick="fucking_close()"></div>
                        </div>
                        <div class="profit-body">
                            <img src="<?= SITE_TEMPLATE_PATH ?>/img/profit.jpg" alt="" class="profit-img">
                            <div class="profit-title">Ваш заказ сформирован</div>
                            <div class="profit-text">Ваш заказ № <?= $result->getID() ?> успешно сформирован.
                                Наши менеджеры скоро свяжутся с вами
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    <? } else { ?>
        <div class="modal profit active">
            <div class="modal-wrap">
                <div class="modal-top">
                    <div class="modal-top_up">
                        <div class="modal-close" onclick="fucking_close()"></div>
                    </div>
                    <div class="profit-body">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/img/fail.png" alt="" class="profit-img">
                        <div class="profit-title">Ошибка!!</div>
                        <div class="profit-text"><?= $user->LAST_ERROR; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?
    }
?>