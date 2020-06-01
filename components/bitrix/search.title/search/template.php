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

$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
    <a class="header_search_mobile" href="javascript:void(0);"></a>
	<form action="<?echo $arResult["FORM_ACTION"]?>" class="header_search">
			<input id="<?echo $INPUT_ID?>" oninput="fast_result(this.value)" type="text" name="q" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>" placeholder="Поиск среди тысяч товаров..." autocomplete="off" class="header_search_input"/>
				<button class="header_search_submit" type="submit" name="s">Найти</button>
        <div class="header_search_result"></div>
	</form>
<?endif?>
<script>
    function fast_result(text,th) {
        BX.ajax({
            url: "<?=$templateFolder . '/ajax.php';?>",
            method: 'POST',
            dataType: 'html',
            async: true,
            processData: true,
            scriptsRunFirst: true,
            emulateOnload: true,
            start: true,
            cache: false,
            data: "title=" + text + "&th=" + th ,
            onsuccess: function (html) {
                $('.header_search_result').addClass('active');
                $('.header_search_result').html(html);
            },
            onfailure: function () {
            }
        });
    }
</script>