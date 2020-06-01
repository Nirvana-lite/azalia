<?
//Подключаем ядро Битрикс и главный модуль
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
foreach ($basket as $arItems){

    $dbPrice = CPrice::GetList(
        array("QUANTITY_FROM" => "ASC", "QUANTITY_TO" => "ASC",
            "SORT" => "ASC"),
        array("PRODUCT_ID" => $arItems->getProductId()),
        false,
        false,
        array("ID", "PRICE", "CURRENCY")
    );
    while ($arPrice = $dbPrice->Fetch()) {
        $arDiscounts = CCatalogDiscount::GetDiscountByPrice(
            $arPrice["ID"],
            $USER->GetUserGroupArray(),
            "N",
            SITE_ID
        );
        $discountPrice = CCatalogProduct::CountPriceWithDiscount(
            $arPrice["PRICE"],
            $arPrice["CURRENCY"],
            $arDiscounts
        );
        $arPrice["DISCOUNT_PRICE"] = $discountPrice;

        if ($arItems->getProductId() == $_POST["p_id"]) {
            $data['id'] = $arItems->getId();
            $data['q_id'] = $arItems->getProductId();
            $data['quantity'] = $arItems->getQuantity();
            if ($_POST['th'] == 'plus'){
                $data['quantity']++;
            }else{
                if ($data['quantity'] != 1){
                    $data['quantity']--;
                }
            }
            $data['all_quantity'] +=$data['quantity'];
            $data['all_price'] += ($arPrice["DISCOUNT_PRICE"] * $data['quantity']);
            $data['price'] = CurrencyFormat($arPrice["DISCOUNT_PRICE"] * $data['quantity'], 'RUB');
    }
    else{
        $data['all_quantity'] += $arItems->getQuantity();
        $data['all_price'] += ($arPrice["DISCOUNT_PRICE"] * $arItems->getQuantity());
    }
    }
}

$data['all_price'] = CurrencyFormat($data['all_price'], 'RUB');

//Создаем переменные для обработчика
$arFields = array(
    "QUANTITY" =>  $data['quantity'],
    "DELAY" => "Y"
);

if (CSaleBasket::Update($data['id'], $arFields))
    echo json_encode($data);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>