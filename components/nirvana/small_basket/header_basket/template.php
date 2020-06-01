<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule('sale');
CModule::IncludeModule('catalog');
use Bitrix\Sale;
$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
if ($basket->getPrice() >0) {
    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();
    $result = $discounts->getApplyResult(true);
}
$data = array();
foreach ($basket as $item) {
    $quantity = $item->getQuantity();
    $basketCode = $item->getBasketCode();
    if (isset($result['PRICES']['BASKET'][$basketCode]))
    {
    $price = $result['PRICES']['BASKET'][$basketCode]['PRICE']* $quantity;
    }else{
        $price = $item->getPrice()* $quantity;
    }
    $data['price'] +=$price;
    $data["quantity"] += $quantity;
}

$data["price"] = CurrencyFormat($data["price"], "RUB");
?>
<div class="header_basket">
    <div class="header_basket_img">
        <div class="header_basket_count"> <?if($data["quantity"] >0){ echo $data["quantity"];}else{echo "0";}?></div>
    </div>
    <div class="header_basket_price"><?if($data["quantity"] >0){ echo $data["price"];}else{echo "Нет товаров";}?></div>
    <a class="header_basket_link" href="<?=$arParams["URL_ORDER"]?>"></a>
</div>