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

    $arViewModeList = $arResult['VIEW_MODE_LIST'];

    $arViewStyles = array(
        'LIST' => array(
            'CONT' => 'bx_sitemap',
            'TITLE' => 'bx_sitemap_title',
            'LIST' => 'bx_sitemap_ul',
        ),
        'LINE' => array(
            'CONT' => 'bx_catalog_line',
            'TITLE' => 'bx_catalog_line_category_title',
            'LIST' => 'bx_catalog_line_ul',
            'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png',
        ),
        'TEXT' => array(
            'CONT' => 'bx_catalog_text',
            'TITLE' => 'bx_catalog_text_category_title',
            'LIST' => 'bx_catalog_text_ul',
        ),
        'TILE' => array(
            'CONT' => 'bx_catalog_tile',
            'TITLE' => 'bx_catalog_tile_category_title',
            'LIST' => 'bx_catalog_tile_ul',
            'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png',
        ),
    );
    $arCurView = $arViewStyles[$arParams['VIEW_MODE']];

    $strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
    $strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
    $arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>
<?
    if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID']) {
        $this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete,
            $arSectionDeleteParams);

        ?>
<?
            $mass = array();
                CModule::IncludeModule("iblock");
                $mass[] = [
                        "NAME" => $arResult['SECTION']['NAME'],
                        "URL" => $arResult['SECTION']['SECTION_PAGE_URL'],

                ];
                if (!empty($arResult['SECTION']['IBLOCK_SECTION_ID'])){
                    $mass[] = [
                        "NAME" => CIBlockSection::GetByID($arResult['SECTION']['IBLOCK_SECTION_ID'])->GetNext()['NAME'],
                        "URL" => CIBlockSection::GetByID($arResult['SECTION']['IBLOCK_SECTION_ID'])->GetNext()['SECTION_PAGE_URL'],
                        "ARROW" => "<span>→</span>"
                    ];
                }
                $mass = array_reverse($mass);
            ?>
        <section class="page_leader">
            <div class="container">
                <div class="page_way">
                    <a class="page_way_link" href="/">Главная</a>
                    <span>→</span>
                    <a class="page_way_link" href="/catalog/">Каталог товаров</a>
                    <span>→</span>
                    <?
                    foreach ($mass as $breadItem){?>
                        <a class="page_way_link" href="<?=$breadItem['URL']?>"><?=$breadItem['NAME']?></a>
                    <?
                    if (isset($breadItem['ARROW']))echo $breadItem['ARROW'];
                    }
                    ?>
                    <p class="page_way_link">
                        <?

                        /*echo(
                        isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
                            ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
                            : $arResult['SECTION']['NAME']
                        );*/
                        ?>
                    </p>
                </div>
                <h1 class="title_main"><?
                        echo(
                        isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
                            ? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
                            : $arResult['SECTION']['NAME']
                        );
                    ?></h1>
            </div>
        </section>
        <?
    }
    if (0 < $arResult["SECTIONS_COUNT"]) {
        ?>

        <?
        switch ($arParams['VIEW_MODE']) {
            case 'TILE':
                $categories_row = 0;
                $newSection = array();
                foreach ($arResult['SECTIONS'] as &$arSection) {
                    if (!$arSection['PICTURE']) {
                        $arSection['PICTURE'] = array(
                            'SRC' => $templateFolder."/images/line-empty.png",
                        );
                    }
                    $categories_row++;
                    if ($categories_row <= 3) {
                        $newSection[0][] = $arSection;
                    } elseif ($categories_row >= 4 && $categories_row <= 7) {
                        $newSection[1][] = $arSection;
                    } elseif ($categories_row >= 8 && $categories_row <= 12) {
                        $newSection[2][] = $arSection;
                    } elseif($categories_row>= 13 && $categories_row <= 15) {
                        $newSection[3][] = $arSection;
                    }else{
                        $newSection[4][] = $arSection;
                    }
                } ?>

                <section class="page_leader">
                  <div class="container">
                    <div class="page_way">
                      <a class="page_way_link" href="/">Главная</a>
                      <span>→</span>
                      <p class="page_way_link">Каталог товаров</p>
                    </div>
                    <h1 class="title_main">Каталог товаров "Азалия Декор"</h1>
                  </div>
                </section>

                <section class="categories">
                    <div class="container">
                        <div class="categories_wrapper">
                            <div class="categories_row one">
                                <? foreach ($newSection[0] as $key => &$arSection) {
                                    if ($key == 2) {
                                        $wrap = "min";
                                    } else {
                                        $wrap = "max";
                                    } ?>
                                    <div class="categories_box <?= $wrap ?>">
                                        <img class="categories_img" src="<?= $arSection['PICTURE']["SRC"] ?>">
                                        <div class="categories_info">
                                            <div class="categories_name"><?= $arSection['NAME'] ?></div>
                                            <?
                                                if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                    <div class="categories_amount"><?= $arSection['ELEMENT_CNT'] ?>
                                                        товаров
                                                    </div>
                                                <?
                                                } ?>
                                        </div>
                                        <a class="categories_link" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
                                    </div>
                                <?
                                } ?>
                            </div>
                            <div class="categories_row two">
                                <? foreach ($newSection[1] as $key => &$arSection) {
                                    if ($key == 2 || $key == 0) {
                                        $wrap = "min";
                                    }elseif ($key == 3){
                                        $wrap = "mid";
                                    }
                                    else {
                                        $wrap = "max";
                                    } ?>
                                    <div class="categories_box <?= $wrap ?>">
                                        <img class="categories_img" src="<?= $arSection['PICTURE']["SRC"] ?>">
                                        <div class="categories_info">
                                            <div class="categories_name"><?= $arSection['NAME'] ?></div>
                                            <?
                                                if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                    <div class="categories_amount"><?= $arSection['ELEMENT_CNT'] ?>
                                                        товаров
                                                    </div>
                                                    <?
                                                } ?>
                                        </div>
                                        <a class="categories_link" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
                                    </div>
                                    <?
                                } ?>
                            </div>
                            <div class="categories_row three">
                                <? foreach ($newSection[2] as $key => &$arSection) {
                                    if ($key == 2 || $key == 0) {
                                        $wrap = "mid";
                                    }
                                    else {
                                        $wrap = "min";
                                    } ?>
                                    <div class="categories_box <?= $wrap ?>">
                                        <img class="categories_img" src="<?= $arSection['PICTURE']["SRC"] ?>">
                                        <div class="categories_info">
                                            <div class="categories_name"><?= $arSection['NAME'] ?></div>
                                            <?
                                                if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                    <div class="categories_amount"><?= $arSection['ELEMENT_CNT'] ?>
                                                        товаров
                                                    </div>
                                                    <?
                                                } ?>
                                        </div>
                                        <a class="categories_link" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
                                    </div>
                                    <?
                                } ?>
                            </div>
                            <div class="categories_row four">
                                <? foreach ($newSection[3] as $key => &$arSection) {
                                    if ( $key == 0) {
                                        $wrap = "min";
                                    }
                                    else {
                                        $wrap = "max";
                                    } ?>
                                    <div class="categories_box <?= $wrap ?>">
                                        <img class="categories_img" src="<?= $arSection['PICTURE']["SRC"] ?>">
                                        <div class="categories_info">
                                            <div class="categories_name"><?= $arSection['NAME'] ?></div>
                                            <?
                                                if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                    <div class="categories_amount"><?= $arSection['ELEMENT_CNT'] ?>
                                                        товаров
                                                    </div>
                                                    <?
                                                } ?>
                                        </div>
                                        <a class="categories_link" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
                                    </div>
                                    <?
                                } ?>
                            </div>
                            <div class="categories_row one">
                                <? foreach ($newSection[4] as $key => &$arSection) {
                                    if ($key == 2) {
                                        $wrap = "min";
                                    } else {
                                        $wrap = "max";
                                    } ?>
                                    <div class="categories_box <?= $wrap ?>">
                                        <img class="categories_img" src="<?= $arSection['PICTURE']["SRC"] ?>">
                                        <div class="categories_info">
                                            <div class="categories_name"><?= $arSection['NAME'] ?></div>
                                            <?
                                                if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                    <div class="categories_amount"><?= $arSection['ELEMENT_CNT'] ?>
                                                        товаров
                                                    </div>
                                                    <?
                                                } ?>
                                        </div>
                                        <a class="categories_link" href="<?= $arSection['SECTION_PAGE_URL'] ?>"></a>
                                    </div>
                                    <?
                                } ?>
                            </div>
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

                <?
                unset($arSection);
                break;

            case 'LIST':
                ?>
                <section class="subcategories">
                    <div class="container">
                        <div class="subcategories_wrapper">
                            <div class="subcategories_left">
                                <div class="subcategories_sidebar">
                                    <div class="subcategories_sidebar_view">Категории</div>
                                    <nav class="subcategories_sidebar_list">
                                        <?
                                            foreach ($arResult['SECTIONS'] as &$arSection) {
                                                if ($arResult["SECTION"]["ID"] !== $arSection["IBLOCK_SECTION_ID"]) {
                                                    continue;
                                                } ?>
                                                <a class="subcategories_sidebar_item"
                                                   href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"]; ?></a>
                                                <?
                                            } ?>
                                    </nav>
                                </div>
                            </div>
                            <div class="subcategories_right">
                                <div class="subcategories_list">
                                    <?
                                        foreach ($arResult['SECTIONS'] as &$arSection) {
                                            if ($arSection["ELEMENT_CNT"] == 0) continue;
                                            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'],
                                                $strSectionEdit);
                                            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'],
                                                $strSectionDelete,
                                                $arSectionDeleteParams);
                                            if ($arResult["SECTION"]["ID"] !== $arSection["IBLOCK_SECTION_ID"]) {
                                                continue;
                                            } ?>
                                            <div class="subcategories_item"
                                                 id="<?= $this->GetEditAreaId($arSection['ID']); ?>">
                                                <?
                                                    if (!$arSection['PICTURE']) {
                                                        $arSection['PICTURE'] = array(
                                                            'SRC' => $templateFolder."/images/line-empty.png",
                                                        );
                                                    }
                                                ?>
                                                <img class="subcategories_img"
                                                     src="<?= $arSection['PICTURE']["SRC"] ?>">
                                                <div class="<?=(mb_strlen($arSection["NAME"]) > 24)?'subcategories_info long':'subcategories_info'?>">
                                                    <div class="subcategories_name"><? echo $arSection["NAME"]; ?></div>
                                                    <?
                                                        if ($arParams["COUNT_ELEMENTS"]) { ?>
                                                            <div class="subcategories_amount"><? echo $arSection["ELEMENT_CNT"]; ?>
                                                                товаров
                                                            </div>
                                                            <?
                                                        } ?>
                                                </div>
                                                <a class="subcategories_link"
                                                   href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"></a>
                                            </div>
                                            <?
                                        } ?>
                                </div>
                                <div class="subcategories_bottom">
                                    <div class="subcategories_slider">
                                        <h2 class="title small">Хит продаж</h2>
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
                                    <!--<div class="subcategories_extra">
                                        <div class="subcategories_info">
                                            <div class="subcategories_description">
                                                <p>Вазы, кашпо, горшки, вазоны, кувшины — аксессуары номер один для
                                                    фитодизайна. Интернет-магазин флористики «Азалия Декор»
                                                    предоставляет возможность <b>купить изделия из керамики</b> разных
                                                    форм и размеров, чтобы максимально подчеркнуть красоту цветов и
                                                    расставить акценты.</p>
                                                <p>В этом разделе каталога представлено более 1600 товаров для
                                                    оформления приусадебного участка, балкона и подоконника цветочными
                                                    композициями и декоративными растениями. Широкий ассортимент товаров
                                                    поможет вам найти всё необходимое для создания гармоничного
                                                    пространства как дома, так и в саду. Цена зависит от размеров и
                                                    материалов изготовления. В каталоге вы найдёте горшки и вазоны,
                                                    балконные ящики, арки, шпалеры, опоры для растений, кустодержатели,
                                                    ограждения для клумб и декоративные фигуры.</p>
                                            </div>
                                            <div class="subcategories_additionally">
                                                <div class="subcategories_description">
                                                    <p>В этом разделе каталога представлено более 1600 товаров для
                                                        оформления приусадебного участка, балкона и подоконника
                                                        цветочными композициями и декоративными растениями. Широкий
                                                        ассортимент товаров поможет вам найти всё необходимое для
                                                        создания гармоничного пространства как дома, так и в саду. Цена
                                                        зависит от размеров и материалов изготовления. В каталоге вы
                                                        найдёте горшки и вазоны, балконные ящики, арки, шпалеры, опоры
                                                        для растений, кустодержатели, ограждения для клумб и
                                                        декоративные фигуры.</p>
                                                    <p>В этом разделе каталога представлено более 1600 товаров для
                                                        оформления приусадебного участка, балкона и подоконника
                                                        цветочными композициями и декоративными растениями. Широкий
                                                        ассортимент товаров поможет вам найти всё необходимое для
                                                        создания гармоничного пространства как дома, так и в саду. Цена
                                                        зависит от размеров и материалов изготовления. В каталоге вы
                                                        найдёте горшки и вазоны, балконные ящики, арки, шпалеры, опоры
                                                        для растений, кустодержатели, ограждения для клумб и
                                                        декоративные фигуры.</p>
                                                    <p>В этом разделе каталога представлено более 1600 товаров для
                                                        оформления приусадебного участка, балкона и подоконника
                                                        цветочными композициями и декоративными растениями. Широкий
                                                        ассортимент товаров поможет вам найти всё необходимое для
                                                        создания гармоничного пространства как дома, так и в саду. Цена
                                                        зависит от размеров и материалов изготовления. В каталоге вы
                                                        найдёте горшки и вазоны, балконные ящики, арки, шпалеры, опоры
                                                        для растений, кустодержатели, ограждения для клумб и
                                                        декоративные фигуры.</p>
                                                </div>
                                            </div>
                                            <a class="subcategories_more" href="javascript:void(0);">Полное описание</a>
                                        </div>
                                        <div class="subcategories_extra_img_wrapper">
                                            <img class="subcategories_extra_img" src="<?/*=SITE_TEMPLATE_PATH*/?>/img/banner-category.jpg">
                                        </div>
                                    </div>-->
                                </div>
                            </div>
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

                <?
                unset($arSection);
                break;
        }
        ?>


        <?
    }
?>