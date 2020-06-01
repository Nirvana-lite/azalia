<?
require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule('sale');
$res = CSaleBasket::GetList(array(), array(
    'FUSER_ID' => CSaleBasket::GetBasketUserID(),
    'LID' => SITE_ID,
    'ORDER_ID' => 'null',
    'CAN_BUY' => 'Y'));
while ($row = $res->fetch()) {
    CSaleBasket::Delete($row['ID']);
}
echo "Ваша корзина пуста";