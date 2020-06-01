<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
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
    //pre($arResult);
?>
<section class="page_leader grey">
    <div class="container">
        <div class="page_way">
            <a class="page_way_link" href="/">Главная</a>
            <span>→</span>
            <a class="page_way_link" href="/news">Новости</a>
            <span>→</span>
            <p class="page_way_link"><?= $arResult['NAME'] ?></p>
        </div>
        <h1 class="title_main"><?= $arResult['NAME'] ?></h1>
    </div>
</section>
<section class="article-page">
    <div class="container">
        <div class="article-page_wrapper">
            <div class="article-page_left">
                <div class="article-page_img_wrapper">
                    <img class="article-page_img" src="<?= $arResult["DETAIL_PICTURE"]['SRC'] ?>">
                    <div class="article-page_marker"><?= $arResult['SECTION']['PATH'][0]['NAME'] ?></div>
                    <div class="article-page_type news">Новости</div>
                </div>
                <div class="article-page_info">
                    <div class="article-page_date"><?= $arResult['DISPLAY_ACTIVE_FROM'] ?></div>
                    <div class="article-page_name"><?= $arResult['NAME'] ?></div>
                    <div class="article-page_description">
                        <?= $arResult['DETAIL_TEXT'] ?>
                    </div>
                    <a class="article-page_back" href="<?= $arResult['SECTION_URL'] ?>">Назад к статьям</a>
                </div>
            </div>
            <div class="article-page_right">
                <div class="article-page_caption">Читайте также</div>
                <?
                    $arSelect = Array('ID', "NAME", 'DATE_CREATE', 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL');
                    $arFilter = Array("IBLOCK_ID" => IntVal(6), "ACTIVE" => "Y", "!ID" => $arResult['ID']);
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 5), $arSelect);
                    while ($ob = $res->GetNext()) {?>
                        <div class="article-page_right_news">
                            <div class="article-page_right_img_wrapper">
                                <img class="article-page_right_img" src="<?=CFile::GetPath($ob['PREVIEW_PICTURE']);?>">
                                <div class="article-page_right_marker none"></div>
                                <div class="article-page_right_type news">Новости</div>
                                <a class="article-page_right_img_link" href="<?=$ob['DETAIL_PAGE_URL']?>"></a>
                            </div>
                            <div class="article-page_right_info">
                                <div class="article-page_right_date"><?=FormatDate("d F Y", MakeTimeStamp($ob['DATE_CREATE']))?></div>
                                <a class="article-page_right_name" href="<?=$ob['DETAIL_PAGE_URL']?>"><?=$ob['NAME']?></a>
                            </div>
                        </div>
                    <? } ?>
            </div>
        </div>
    </div>
</section>



<section id="may-like" class="may-like">
    <div class="container">
        <div class="may-like_slider">
            <h2 class="title small">Вам может понравится</h2>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?
                    $val = 'Хит';
                    $arFilter = Array("IBLOCK_ID" => IntVal(13), array("ACTIVE" => "Y", "PROPERTY_HIT_VALUE" => $val));
                    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nTopCount" => 16), $arSelect);
                    while ($ob = $res->Fetch()) { ?>
                        <div class="swiper-slide">
                            <? $APPLICATION->IncludeComponent(
                                "nirvana:item",
                                ".default",
                                Array(
                                    "ITEM_ID" => $ob['ID'],
                                    "IBLOCK_ID" => 13
                                ),
                                false
                            ); ?>
                        </div>
                    <? } ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
<section id="subscription" class="subscription">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:sender.subscribe",
            ".default",
            array(
                "AJAX_MODE" => "N",
                "AJAX_OPTION_ADDITIONAL" => "",
                "AJAX_OPTION_HISTORY" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "A",
                "CONFIRMATION" => "N",
                "HIDE_MAILINGS" => "N",
                "SET_TITLE" => "N",
                "SHOW_HIDDEN" => "N",
                "USER_CONSENT" => "Y",
                "USER_CONSENT_ID" => "1",
                "USER_CONSENT_IS_CHECKED" => "N",
                "USER_CONSENT_IS_LOADED" => "N",
                "USE_PERSONALIZATION" => "Y",
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );?>
    </div>
</section>
