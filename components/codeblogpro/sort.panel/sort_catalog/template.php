<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
<div class="catalog-right_top_cat">
    <div class="catalog-right_top_down">
        <? Loc::getMessage('CODEBLOGPRO_SORT_PANEL_COMPONENT_TEMPALTE_SORT_BY_VALUE') ?>
        <? foreach ($arResult['SORT']['PROPERTIES'] as $property) { ?>
            <?
            if ($property['NAME'] == 'По популярности'){$p_name = 'Популярные';}
            elseif ($property['NAME'] == 'Новинка'){$p_name = 'Новинки';}
            elseif ($property['NAME'] == 'Старая цена'){$p_name = 'Скидки и акции';}
            elseif ($property['NAME'] == 'Розничная цена'){$p_name = 'Цена';}
            ?>
            <? if ($property['ACTIVE']) {
                if ($property['CODE'] != 'rand') {
                    if (strpos($property['ORDER'], 'asc') !== false) {

                        $ebola='up';
                    }
                    elseif (strpos($property['ORDER'], 'desc') !== false) {

                        $ebola='down';
                    }
                }
                ?>

                <a class="catalog-right_top_link active <?=$ebola?>" href="<?= $property['URL']; ?>"><?= $p_name?><?
                    /**
                     * Show sorting direction
                     */

                    ?></a>
            <? } else { ?>
                <a class="catalog-right_top_link" href="<?= $property['URL']; ?>"><?= $p_name ?></a>
            <? }
        }
        } ?>
    </div>
</div>


