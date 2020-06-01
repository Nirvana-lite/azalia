<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

/*echo "<pre>";
print_r($arResult);
echo "</pre>";*/

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<?if($arResult["bDescPageNumbering"] === true):?>
    <?if ($arResult["NavPageNomer"] > 1):?>
<!--        <div class="catalog_row">
            <a href="<?/*=$arResult["sUrlPath"]*/?>?<?/*=$strNavQueryString*/?>PAGEN_<?/*=$arResult["NavNum"]*/?>=<?/*=($arResult["NavPageNomer"]-1)*/?>" class="catalog_more"><?/*=GetMessage("next")*/?></a>
        </div>-->
    <?endif?>

	<?=$arResult["NavFirstRecordShow"]?> <?=GetMessage("nav_to")?> <?=$arResult["NavLastRecordShow"]?> <?=GetMessage("nav_of")?> <?=$arResult["NavRecordCount"]?>



<nav class="page_nav" id="1">
	<?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
		<?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
			<b class="page_nav_number active"><?=$NavRecordGroupPrint?></b>
		<?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
			<a class="page_nav_number" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
		<?else:?>
			<a class="page_nav_number" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
		<?endif?>

		<?$arResult["nStartPage"]--?>
	<?endwhile?>
</nav>
<?else:?>


<nav class="page_nav" id="2">
    <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
<!--
        <div class="catalog_row">
            <a href="<?/*=$arResult["sUrlPath"]*/?>?<?/*=$strNavQueryString*/?>PAGEN_<?/*=$arResult["NavNum"]*/?>=<?/*=($arResult["NavPageNomer"]-1)*/?>" class="catalog_more"><?/*=GetMessage("next")*/?></a>
        </div>-->
    <?endif?>
	<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
		<?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                <a href="#" class="page_nav_number active"><?=$arResult["nStartPage"]?></a>
		<?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>

                <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="page_nav_number"><?=$arResult["nStartPage"]?></a>
		<?else:?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>" class="page_nav_number"><?=$arResult["nStartPage"]?></a>
		<?endif?>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>
</nav>
<?endif?>
