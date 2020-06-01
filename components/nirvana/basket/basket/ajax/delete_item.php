<?php
//Подключаем ядро Битрикс и главный модуль
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');

$delItem = IntVal($_POST['p_id']);

$res = CSaleBasket::GetList(array(), array(
    'FUSER_ID' => CSaleBasket::GetBasketUserID(),
    'LID' => SITE_ID,
    'ORDER_ID' => 'null',
    'CAN_BUY' => 'Y'));
$data['count'] = 0;
$data['allSumm'] = 0;
$data['quantity'] = 0;
while ($row = $res->fetch()) {
    if ($row['PRODUCT_ID'] == $delItem){
    CSaleBasket::Delete($row['ID']);
    $data['del'] = $row['PRODUCT_ID'];
    }
    else{
        $data['count']++;
        $data['allSumm'] += $row['PRICE']*$row['QUANTITY'];
        $data['quantity'] +=$row['QUANTITY'];
    }
}

$number = substr($data['count'], -2);

    $number = substr($number, -1);
    if($number == 1 ) {$term = "е";}
    elseif($number >= 2  && $number <= 4) {$term = "я";}
    else{$term = "й";}

$data['count'] = "{$data['count']} наименовани$term";

$data['allSumm'] = CurrencyFormat($data['allSumm'], 'RUB');
echo json_encode($data);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>



