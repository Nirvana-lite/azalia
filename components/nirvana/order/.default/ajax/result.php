<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $USER;

use Bitrix\Main,
    Bitrix\Main\Localization\Loc as Loc,
    Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Sale\DiscountCouponsManager,
    Bitrix\Main\Context;

if (!Loader::IncludeModule('sale'))
    die();

function guardAuth($input)
{
    $input = trim($input); // - пробелы
    $input = stripslashes($input); // - экранированныe символы
    $input = strip_tags($input); //  - тэги
    $input = htmlspecialchars($input); // преобразуем в сущности если что то осталось

    return $input;
}
function pre($item){
    echo "<pre>";
    print_r($item);
    echo "</pre>";
}
$olddata = $_POST;


$data = array();
foreach ($olddata as $key => $item){
    $data[$key] = guardAuth($item);
}
//pre($data);
function getPropertyByCode($propertyCollection, $code)  {
    foreach ($propertyCollection as $property)
    {
        if($property->getField('CODE') == $code)
            return $property;
    }
}

$siteId = \Bitrix\Main\Context::getCurrent()->getSite();

$fio = $data['user_name']." ".$data['user_lastName'];
$phone = $data['user_phone'];
$email = $data['user_mail'];

global $USER;
if ($USER->IsAuthorized()) {
    $userId = $USER->GetID();
}else{
    $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

    $max = 10;
    $size = StrLen($chars) - 1;
    $password = null;
    while ($max--)
        $password .= $chars[rand(0, $size)];
    $user = new CUser;
    $arFields = Array(
        "NAME" => $data["user_name"],
        "LAST_NAME" => $data["user_lastName"],
        "EMAIL" => $data["user_mail"],
        "LOGIN" => $data["user_mail"],
        "PERSONAL_PHONE" => $data["user_phone"],
        "LID" => "ru",
        "ACTIVE" => "Y",
        "GROUP_ID" => array(5),
        "PASSWORD" => $password,
        "CONFIRM_PASSWORD" => $password
    );

    $userId = $user->Add($arFields);
}

$currencyCode = Option::get('sale', 'default_currency', 'RUB');

DiscountCouponsManager::init();

$order = Order::create($siteId, $userId);

$order->setPersonTypeId(1);
$basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), $siteId)->getOrderableItems();
if ($basket->getPrice() < 10000)die();

$order->setBasket($basket);

/*Shipment*/
$shipmentCollection = $order->getShipmentCollection();
$shipment = $shipmentCollection->createItem();
$shipmentItemCollection = $shipment->getShipmentItemCollection();
$shipment->setField('CURRENCY', $order->getCurrency());
foreach ($order->getBasket() as $item)
{
    $shipmentItem = $shipmentItemCollection->createItem($item);
    $shipmentItem->setQuantity($item->getQuantity());
}
$arDeliveryServiceAll = Delivery\Services\Manager::getRestrictedObjectsList($shipment);
$shipmentCollection = $shipment->getCollection();

if (!empty($arDeliveryServiceAll)) {
    if ($data['delivery'] == 2) {
        reset($arDeliveryServiceAll);
        $deliveryObj = current($arDeliveryServiceAll);
    }else{
        reset($arDeliveryServiceAll);
        $deliveryObj = next($arDeliveryServiceAll);
    }
    if ($deliveryObj->isProfile()) {
        $name = $deliveryObj->getNameWithParent();
    } else {
        $name = $deliveryObj->getName();
    }

    $shipment->setFields(array(
        'DELIVERY_ID' => $deliveryObj->getId(),
        'DELIVERY_NAME' => $name,
        'CURRENCY' => $order->getCurrency()
    ));

    $shipmentCollection->calculateDelivery();
}
/**/

/*Payment*/
$arPaySystemServiceAll = [];
if (is_int($data['user_pay']) && !empty($data['user_pay']) ) {
    $paySystemId = $data['user_pay'];
}else{
    $paySystemId = 1;
}
$paymentCollection = $order->getPaymentCollection();

$remainingSum = $order->getPrice() - $paymentCollection->getSum();
if ($remainingSum > 0 || $order->getPrice() == 0)
{
    $extPayment = $paymentCollection->createItem();
    $extPayment->setField('SUM', $remainingSum);
    $arPaySystemServices = PaySystem\Manager::getListWithRestrictions($extPayment);

    $arPaySystemServiceAll += $arPaySystemServices;

    if (array_key_exists($paySystemId, $arPaySystemServiceAll))
    {
        $arPaySystem = $arPaySystemServiceAll[$paySystemId];
    }
    else
    {
        reset($arPaySystemServiceAll);

        $arPaySystem = current($arPaySystemServiceAll);
    }

    if (!empty($arPaySystem))
    {
        $extPayment->setFields(array(
            'PAY_SYSTEM_ID' => $arPaySystem["ID"],
            'PAY_SYSTEM_NAME' => $arPaySystem["NAME"]
        ));
    }
    else
        $extPayment->delete();
}
/**/

$order->doFinalAction(true);
$propertyCollection = $order->getPropertyCollection();

$emailProperty = getPropertyByCode($propertyCollection, 'EMAIL');
$emailProperty->setValue($email);

$phoneProperty = getPropertyByCode($propertyCollection, 'PHONE');
$phoneProperty->setValue($phone);

$order->setField('CURRENCY', $currencyCode);
//Комментарий менеджера
$order->setField('COMMENTS', 'Комментарии менеджера');
//Комментарий покупателя
$order->setField('USER_DESCRIPTION', $data['comment']);

$order->save();

$orderId = $order->GetId();

echo $orderId;