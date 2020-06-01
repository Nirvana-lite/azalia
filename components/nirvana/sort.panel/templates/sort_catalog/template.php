<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (!empty($arResult['SORT']['PROPERTIES'])) {
    // популярные
    // новинки
    // дорогие
    // дешевые
    ?>
<div class="catalog-right_top_cat">
    <div class="catalog-right_top_down">
        <? Loc::getMessage('CODEBLOGPRO_SORT_PANEL_COMPONENT_TEMPALTE_SORT_BY_VALUE') ?>
        <? foreach ($arResult['SORT']['PROPERTIES'] as $property) { ?>

            <? if ($property['ACTIVE']) {
                if ($property['CODE'] != 'rand') {
                    if (strpos($property['ORDER'], 'asc') !== false) {

                        $mark='up';
                    }
                    elseif (strpos($property['ORDER'], 'desc') !== false) {

                        $mark='down';
                    }
                }
                ?>

                <a class="catalog-right_top_link active <?=$mark?>" href="<?= $property['URL']; ?>">ф<?= $property['NAME']?><?
                    /**
                     * Show sorting direction
                     */

                    ?></a>
            <? } else { ?>
                <a class="catalog-right_top_link" href="<?= $property['URL']; ?>"><?= $property['NAME'] ?></a>
            <? }
        }
        } ?>
    </div>
</div>


