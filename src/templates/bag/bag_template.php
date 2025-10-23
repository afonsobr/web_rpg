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

<div <?= $currentTab['inventory'] ?> id="bag-inventory">
    <div class="w-100 input-area pb-4">
        <div class="rounded bg-surface search-input d-flex p-3">
            <input class="p-2" type="text" id="inventory-search-input" placeholder="Search for an item..." autocomplete="off">
        </div>
    </div>
    <div id="inventory-list-container" class="rounded bg-surface">
        <?php foreach ($inventoryList as $playerItem): ?>
            <?php if ($playerItem->quantity == 0)
                continue; ?>
            <div class="p-3 cursor-pointer inventory-item" onclick="openItemWindow(<?= $playerItem->id ?>)">
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
// 1. Pega a lista de slots e ícones diretamente do Helper.
$slotsToDisplay = Helper::getEquipmentSlotInfo();
?>

<div <?= $currentTab['equipment'] ?> id="bag-equipment" class="pb-4">
    <?php foreach ($slotsToDisplay as $slotDbName => $slotInfo): ?>
        <?php
        // 2. Mapeia o nome do slot do BD (snake_case) para o nome da propriedade da classe (camelCase).
        $propertyName = TamersNetwork\Model\Equipment::getPropertyNameForDbSlot($slotDbName);
        // 3. Acessa a propriedade dinamicamente no objeto $tamerEquipment para pegar o item.
        $item = ($propertyName && property_exists($tamerEquipment, $propertyName)) ? $tamerEquipment->$propertyName : null;
        ?>
        <div <?= $item ? sprintf('onclick="showUnequipConfirmation(\'%s\')"', $propertyName) : sprintf('onclick="openSelectEquipmentWindow(\'%s\')"', $propertyName) ?> class="pb-4">
            <div class="font-normal text-sm py-1 pl-3">
                <?= strtoupper($slotInfo['display']) // Usa o nome de exibição do Helper ?>
            </div>
            <div class="p-3 rounded bg-surface cursor-pointer">
                <div class="d-flex w-100">
                    <div class="d-flex <?= $item ? '' : 'opacity-50' ?> items-center justify-center flex-col" style="width: 60px">
                        <?php
                        if ($item) {
                            echo '<i class="fa-solid ' . $item->icon . '"></i>';

                        } else {
                            echo '<i class="fa-solid fa-' . $slotInfo['icon'] . '"></i>';
                        }
                        ?>
                    </div>
                    <div class="d-flex <?= $item ? '' : 'opacity-50' ?> w-100 items-center justify-between">
                        <div class="font-normal">
                            <?= $item ? htmlspecialchars($item->name) : 'Empty' ?>
                            <!-- <?= var_dump($tamerEquipment) ?> -->
                        </div>
                        <div hidden class="text-sm">
                            <?= $item ? 'x1' : '' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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