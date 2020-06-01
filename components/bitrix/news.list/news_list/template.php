<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>

<a class="blog_more" href="/news/">Все новости</a>
<div class="intro_wrapper">
<div class="swiper-container">
<div class="swiper-wrapper">
<? foreach ($arResult["ITEMS"] as $arItem): ?>
    <?
//    pre($arItem);
    ?>

<div class="swiper-slide">
    <div class="blog_news">
        <div class="blog_img_wrapper">
            <img class="blog_img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
            <?if($SectionName = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"])->GetNext()["NAME"]):?>
            <div class="blog_marker"><?=$SectionName;?></div>
            <?endif;?>
            <div class="blog_type article">Статьи</div>
            <a class="blog_img_link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
        </div>
        <div class="blog_info">
            <div class="blog_date"><?=FormatDate("d F Y", MakeTimeStamp($arItem["ACTIVE_FROM"]))?></div>
            <a class="blog_name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
        </div>
    </div>
</div>
<? endforeach; ?>
</div>
    <div class="swiper-pagination"></div>
</div>
</div>