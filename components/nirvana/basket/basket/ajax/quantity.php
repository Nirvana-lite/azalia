<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');

use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

foreach ($basket as $item) {
    if ($item->getProductId() == $_POST["p_id"]) {
        $basketCode = $item->getBasketCode();
        $q = $item->getQuantity();

        if ($_POST['th'] == 'plus') {
            $q++;
        } else {
            if ($q != 1) {
                $q--;
            }
        }
        break;
    }
}
$arFields = array(
    "QUANTITY" => $q,
);
if (CSaleBasket::Update($basketCode, $arFields)) {

    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    if ($basket->getPrice() > 0) {
        $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
        $discounts->calculate();
        $result = $discounts->getApplyResult(true);
    }
    $data = array();
    $price = 0;
    foreach ($basket as $item) {
        $basketCode = $item->getBasketCode();
        if (isset($result['PRICES']['BASKET'][$basketCode])) {
            $price = $result['PRICES']['BASKET'][$basketCode]['PRICE'] * $item->getQuantity();
        } else {
            $price = $item->getPrice() * $item->getQuantity();
        }
        if ($item->getProductId() == $_POST["p_id"]) {
            $data['oldPrice'] = $item->getPrice() * $item->getQuantity();
            $data['quantity'] = $item->getQuantity();
            $data['price'] = $price;
        }
    }

    $data['oldPrice']= CurrencyFormat($data['oldPrice'], 'RUB');
    $data['price'] = CurrencyFormat($data['price'], 'RUB');
    echo json_encode($data);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>