<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

    use \Bitrix\Main\Localization\Loc;
?>
<div class="swiper-slide">
    <?
 $APPLICATION->IncludeComponent(
    "nirvana:item",
    ".default",
    Array(
        "ITEM_ID" => $item['ID'],
        "IBLOCK_ID" => 13
    ),
    false
);
?>
</div>
