<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
use Bitrix\Sale;

$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());

?>
<?
$itemQuantity =0;
$basketItemsCount = 0;
foreach ($basket as $item) {
    $res = GetIBlockElement($item->getProductId());
    if (!$item->isDelay()) continue;
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
//pre($res);
    if (!$res['PREVIEW_PICTURE']) {
        $img = $templateFolder . "/img/no_photo.png";
    } else {
        $img = CFile::GetPath($res['PREVIEW_PICTURE']);
    }
    pre($item);
//                            pre($res);
}
?>
