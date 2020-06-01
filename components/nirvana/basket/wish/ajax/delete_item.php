<?php
//Подключаем ядро Битрикс и главный модуль
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');

$delItem = IntVal($_POST['p_id']);

$res = CSaleBasket::GetList(array(), array(
    'FUSER_ID' => CSaleBasket::GetBasketUserID(),
    'LID' => SITE_ID,
    'ORDER_ID' => 'null',
    'DELAY' => 'Y',
    'CAN_BUY' => 'Y'));
while ($row = $res->fetch()) {
    if ($row['PRODUCT_ID'] == $delItem){
    CSaleBasket::Delete($row['ID']);
    $data['del'] = $row['PRODUCT_ID'];
    }
}

echo json_encode($data);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>



