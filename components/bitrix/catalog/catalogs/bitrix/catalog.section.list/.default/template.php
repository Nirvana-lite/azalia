<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<? if ($APPLICATION->GetCurPage(false) === '/catalog/'): ?>

<section class="categories">
    <div class="container grid categories-grid">
<??>
<?
$s_count = 0;
foreach($arResult["SECTIONS"] as $arSection):

	$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
	$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));

	if($arSection["DEPTH_LEVEL"] ==1):
        $s_count++;
        $arFilterSeo = Array('IBLOCK_ID'=>$arSection['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y', "ID"=>$arSection['ID']);
        $uf_ = CIBlockSection::GetList(Array(), $arFilterSeo, true, Array('UF_SIZE'));
while($val  = $uf_->GetNext())
{
    $arSection['UF_POLIA'] = $val['UF_SIZE'];
}
if ($arSection['UF_POLIA'] == 1){$u_suze = 'big';}else{$u_suze = 'small';}
	?>
        <div class="categories-box categories<?=$s_count?> categories-<?=$u_suze?>">
            <img src="<?=$arSection['PICTURE']['SAFE_SRC']?>" alt="" class="categories-box_img">
            <div class="categories-box_absl">
                <p class="categories-box_absl_title"><?=$arSection["NAME"]?></p>
                <p class="categories-box_absl_text">Более <?=$arSection["ELEMENT_CNT"]?> наименований</p>
                <? if($u_suze == 'big'){?>
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="categories-box_link">Показать все</a>
                <?}?>
            </div>
            <? if($u_suze == 'small'){?>
                <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="categories-box_link_absl"></a>
            <?}?>
        </div>
		<?
endif;
endforeach;
?>
    </div>
</section>
<? endif; ?>