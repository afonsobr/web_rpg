<?php

?>

<div class="w-100">
    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <div>
                <div class="modal-close-button">
                    <?php
                    if ($itemArray->isBlocked) {
                        echo '<i class="fa-solid fa-lock"></i>';
                    }
                    ?>
                    <!-- <i class="fa-solid fa-lock"></i> -->
                </div>
            </div>
        </div>
        <div class="flex-grow text-center">
            <div class="">
                <?= $itemArray->item->name ?>
            </div>
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div>
        <div class="text-center text-xs font-normal pb-3" id="item-quantity">
            <span>
                QUANTITY: <?= $itemArray->quantity ?>
            </span>
        </div>
        <div hidden class="text-center text-xs font-normal" id="item-quantity">
            <span>
                TYPE: <?= strtoupper($itemArray->item->type1) ?>
            </span>
        </div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= $itemArray->item->icon ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                <?= ucfirst($itemArray->item->type1) ?>
                            </div>
                            <div class="item-name">
                                <?= ucfirst($itemArray->item->type2) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-3">
            <!-- <hr> -->
        </div>
        <div class="pl-3 pb-3">
            <div>
                <div class="item-description">
                    <?= $itemArray->item->description ?>
                </div>
            </div>
        </div>
        <div class="pl-3 pb-3">
            <div>
                <div class="item-lore">
                    <?= $itemArray->item->lore ?>
                </div>
            </div>
        </div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3 cursor-pointer" onclick="protectItem(<?= $itemArray->id ?>)">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <?php
                            if ($itemArray->isBlocked) {
                                echo '<i class="fa-solid fa-unlock"></i>';
                            } else {
                                echo '<i class="fa-solid fa-lock"></i>';
                            }
                            ?>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                <?php
                                if ($itemArray->isBlocked) {
                                    echo 'Unprotect Item';
                                } else {
                                    echo 'Protect Item';
                                }
                                ?>
                            </div>
                            <div class="item-name">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (!$itemArray->isBlocked):
                        ?>
                        <div class="d-flex justify-between p-3 text-danger cursor-pointer">
                            <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                <i class="fa-solid fa-trash"></i>
                            </div>
                            <div class="d-flex w-100 items-center justify-between">
                                <div class="item-name">
                                    Delete Item
                                </div>
                                <div class="item-name">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php

function processStats($statString)
{
    $statsName['atk'] = 'Attack';
    $statsName['def'] = 'Defense';
    $statsName['br'] = 'Battle Rating';
    $statsName['hp'] = 'HP';
    $statsName['ds'] = 'DS';

    $return = '';
    $stats = json_decode($statString, true);
    if ($stats != null && is_array($stats)) {
        foreach ($stats as $s => $v) {
            $name = $statsName[$s];
            $return .= "※ {$name} +{$v}<br>";
        }
    }
    return $return;
}
?>

<style>
    #item-quantity {
        /* background-color: var(--color-text); */
    }

    #item-quantity span {
        /* filter: invert(1); */
        color: var(--color-text-muted);
    }

    .item-description {
        /* border-left: 2px solid var(--color-text); */
        /* padding-left: 16px; */
        /* font-size: small; */
        color: var(--color-text);
    }

    .item-lore {
        border-left: 2px solid var(--color-text-muted);
        padding-left: 16px;
        font-size: small;
        color: var(--color-text-muted);
    }
</style>