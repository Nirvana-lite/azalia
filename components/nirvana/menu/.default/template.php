<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}?>
        <div class="nav_menu">
            <ul class="nav_menu_list">
                <? foreach ($arResult as $mailSection): ?>
                    <li class="nav_menu_item">
                        <a class="nav_menu_link" href="<?= $mailSection['URL'] ?>"><?= $mailSection['NAME'] ?></a>
                        <div class="nav_dropdown">
                            <div class="nav_dropdown_left">
                                <a class="nav_dropdown_back" href="javascript:void(0);">Назад</a>
                                <? $chankSection = array_chunk($mailSection['DEPT'], 3); ?>
                                <? for ($i = 0; $i < 3; $i++): ?>
                                    <div class="nav_dropdown_col">
                                        <? foreach ($chankSection[$i] as $secondkey => $secondSection): ?>
                                            <? if (!isset($secondSection['DEPT_2'])): ?>
                                                <a class="nav_dropdown_name link"
                                                   href="<?= $secondSection['URL'] ?>"><?= $secondSection['NAME'] ?></a>
                                            <? else: ?>
                                                <div class="nav_dropdown_list">
                                                    <a class="nav_dropdown_name"
                                                       href="<?= $secondSection['URL'] ?>"><?= $secondSection['NAME'] ?></a>
                                                    <? foreach ($secondSection['DEPT_2'] as $thKey => $theardSection): ?>
                                                        <a class="nav_dropdown_link"
                                                           href="<?= $theardSection['URL'] ?>"><?= $theardSection['NAME'] ?></a>
                                                    <? endforeach; ?>
                                                </div>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    </div>
                                <? endfor; ?>
                            </div>
                            <div class="nav_dropdown_right">
                                <?
                                    $res = CIBlockElement::GetByID($mailSection['ITEM']);
                                    while ( $ar_res = $res->GetNextElement()){
                                    $el = $ar_res->GetFields();
                                }?>
                                <? $APPLICATION->IncludeComponent(
                                    "nirvana:item",
                                    ".default",
                                    Array(
                                        "ITEM_ID" => $el['ID'],
                                        "IBLOCK_ID" => 13
                                    ),
                                    false
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>