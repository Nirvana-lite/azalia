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

function EditData ($DATA) // конвертирует формат даты с 04.11.2008 в 04 Ноября, 2008
{
    $MES = array(
        "01" => "Января",
        "02" => "Февраля",
        "03" => "Марта",
        "04" => "Апреля",
        "05" => "Мая",
        "06" => "Июня",
        "07" => "Июля",
        "08" => "Августа",
        "09" => "Сентября",
        "10" => "Октября",
        "11" => "Ноября",
        "12" => "Декабря"
    );
    $arData = explode(".", $DATA);
    $d = ($arData[0] < 10) ? substr($arData[0], 1) : $arData[0];

    $newData = $d." ".$MES[$arData[1]]." ".$arData[2];
    return $newData;
}
?>


    <section class="blog">
        <div class="container">
            <h2 class="title">Наш блог</h2>
            <div class="blog_wrapper">
                <a class="blog_more" href="javascript:void(0);">Все новости</a>
                <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                // pre($arItem);
                ?>
                <div class="blog_news">
                    <div class="blog_img_wrapper">
                        <img class="blog_img" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
                        <div class="blog_marker">Полезное</div>
                        <div class="blog_type article">Статьи</div>
                        <a class="blog_img_link" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
                    </div>
                    <div class="blog_info">
<!--                        <div class="blog_date">--><?//= date("d.m.y",strtotime($arItem["DATE_CREATE"]))?><!--</div>-->
                        <div class="blog_date"><?=EditData(date("d.m.Y",strtotime($arItem["DATE_CREATE"])))?></div>
                        <a class="blog_name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                    </div>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </section>


