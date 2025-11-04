<?php
// O template agora só precisa do namespace do Helper.
use TamersNetwork\Helper\Helper;

$currentTab['inventory'] = '';
$currentTab['equipment'] = 'hidden';

if (isset($_GET['tab'])) {
    if ($_GET['tab'] == 'equipment') {
        $currentTab['inventory'] = 'hidden';
        $currentTab['equipment'] = '';
    }
}
?>


<div class="w-100">

    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <!-- <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-arrow-left"></i></button> -->
        </div>
        <div class="flex-grow text-center">
            Battle Card Select
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div id="inventory-list-container" class="rounded bg-surface">
        <div class="p-3 cursor-pointer inventory-item" onclick="selectBattleCard(0)">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                    <i class="fa-solid fa-empty-set"></i>
                </div>
                <div class="d-flex w-100 items-center justify-between">
                    <div class="font-normal item-name">
                        Remove Battle Card
                    </div>
                    <div class="text-sm">

                    </div>
                </div>
            </div>
        </div>
        <?php foreach ($inventoryList as $playerItem): ?>
            <?php if ($playerItem->quantity == 0)
                continue; ?>
            <?php if ($playerItem->item->type1 != 'battleCard')
                continue; ?>
            <div class="p-3 cursor-pointer inventory-item" onclick="selectBattleCard('<?= $playerItem->id ?>')">
                <div class="d-flex w-100">
                    <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                        <i class="fa-solid <?= $playerItem->item->icon ?>"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="font-normal item-name">
                            <?= $playerItem->item->name ?>
                        </div>
                        <div class="text-sm">
                            x<?= $playerItem->quantity ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>