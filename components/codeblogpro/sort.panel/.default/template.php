<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

if (!empty($arResult['SORT']['PROPERTIES'])) { ?>
    <?
        $a = array_values($arResult['SORT']['PROPERTIES']);
        $key = array_search('1', array_column($a, 'ACTIVE'));

    if ($a[$key]['NAME'] == 'По популярности'){$p_name = 'Популярные';}
    elseif ($a[$key]['NAME'] == 'По новизне'){$p_name = 'Новинки';}
    elseif ($a[$key]['NAME'] == 'Клиенты с сайта розница'){$p_name = 'Цена';}
    ?>
<div class="catalog_sorting_main"><?=$p_name?></div>
<div class="catalog_sorting_list">
    <? foreach ($arResult['SORT']['PROPERTIES'] as $property) {
        if ($property['NAME'] == 'По популярности'){$p_name = 'Популярные';}
        elseif ($property['NAME'] == 'По новизне'){$p_name = 'Новинки';}
        elseif ($property['NAME'] == 'Клиенты с сайта розница'){$p_name = 'Цена';}
        ?>
        <? if ($property['ACTIVE']) { ?>
            <a class="catalog_sorting_item" href="<?= $property['URL']; ?>">
                <strong><?= $p_name?></strong><?
            ?></a>
        <? } else { ?>
            <a href="<?= $property['URL']; ?>" class="catalog_sorting_item"><?= $p_name ?></a>
        <? }
    }
} ?>
</div>
<??>