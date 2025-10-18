<?php

?>
<div id="bag-inventory">
    <div class="w-100 input-area pb-4">
        <div class="rounded bg-surface search-input d-flex p-3">
            <input class="p-2" type="text" id="inventory-search-input" placeholder="Search for an item..." autocomplete="off">
        </div>
    </div>
    <div id="inventory-list-container" class="rounded bg-surface pb-4">
        <?php foreach ($inventoryList as $playerItem): ?>
            <?php if ($playerItem->quantity == 0) {
                continue;
            } ?>
            <div class="p-3 cursor-pointer inventory-item">
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

<?php
$availableSlots = array(
    'hat' => 'head-side',
    'headset' => 'headphones',
    'glasses' => 'glasses',
    'hands' => 'hand',
    'jacket' => 'vest',
    'upper_body' => 'shirt',
    'lower_body' => 'pants',
    'boots' => 'boot',
    'ring' => 'ring-diamond',
    'bracelet' => 'ring',
    'gem' => 'dice-d10',
    'backpack' => 'backpack',
    'digivice' => 'mobile',
    'chipset' => 'microchip',
    'aura' => 'spiral',
);
?>

<div id="bag-equipment" class="pb-4" hidden>
    <?php foreach ($availableSlots as $slotName => $icon): ?>
        <div class="pb-4">
            <div class="font-normal text-sm py-1 pl-3">
                <?= strtoupper($slotName) ?>
            </div>
            <div class="p-3 rounded bg-surface cursor-pointer">
                <div class="d-flex w-100">
                    <div class="d-flex items-center justify-center flex-col" style="width: 60px">
                        <i class="fa-solid fa-<?= $icon ?>"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="font-normal">
                            Item Name
                        </div>
                        <div class="text-sm">
                            x1
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div hidden class="pt-4">
        <div class="font-normal text-sm py-1 pl-3">
            TAMER
        </div>
        <div class="p-3 rounded bg-surface">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col text-xl" style="width: 60px">
                    <i class="fa-solid fa-hat-wizard"></i>
                </div>
                <div class="d-flex w-100 items-center justify-between">
                    <div class="font-normal">
                        Item Name
                    </div>
                    <div class="text-sm">
                        x1
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .search-input input {
        background-color: transparent;
        width: 100%;
        border: 0px;
        outline: none;
        color: var(--color-text);
    }
</style>