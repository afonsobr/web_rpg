<?php

use TamersNetwork\Repository\InventoryRepository;
// $_SESSION['map'] = null;
?>
<div class="pb-4">
    <div class="map-bg bg-jijimon-house rounded p-3">
        <span>
            <!-- Jijimon's House -->
        </span>

    </div>
</div>

<div class="">
    <div class="font-normal py-1 pl-3">
        JIJIMON'S HOUSE
    </div>
    <div class="font-normal text-sm py-1 pl-3">
        JIJIMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Ah, welcome, young Tamer! This is my humble home. You’ve traveled far to reach the Village, haven’t you? Please, rest a while — you’re always welcome here.
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Here, you may use the Incubation System. With the right data and care, you can hatch a Digimon — life born from the code of the Digital World itself!
        </div>
    </div>
</div>

<?php
echo returnToVBBtn();
?>

<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            HATCHING SYSTEM
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between p-3 cursor-pointer" onclick="openSelectDataWindow()">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <i class="fa-solid fa-file"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Select a Data
                        </div>
                        <div class="item-name">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['data_for_hatch'])) {
        $inventoryId = $_SESSION['data_for_hatch']->id;
        if (!isset($inventoryRepo)) {
            $inventoryRepo = new InventoryRepository($pdo);
        }
        $itemArray = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, $inventoryId);
        $reqQuantity = ($itemArray->item->type2 === 'corrupted') ? 10 : 1;
        $quantity_color = ($itemArray->quantity >= $reqQuantity) ? 'text-success' : 'text-danger';
        ?>
        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                CURRENT DATA FOR HATCHING:
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                            <i class="fa-solid <?= $itemArray->item->icon ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                <?= $itemArray->item->name ?>
                            </div>
                            <div class="item-name">
                                <span class="<?= $quantity_color ?>">x
                                    <?= $itemArray->quantity ?>
                                </span>
                                / <small>
                                    <?= $reqQuantity ?>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Hatch Now
                            </div>
                            <div class="item-name">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3 cursor-pointer">
                        <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                            <i class="fa-solid fa-play"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between" onclick="hatchNow()">
                            <div class="item-name">
                                Hatch Now
                            </div>
                            <div class="item-name">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>


<style>
    .description {
        padding-left: 10px;
        border-left: 2px solid var(--color-text);
    }
</style>