<?php
$quantity = 1;
$costEach = $itemArray->price;
$costTotal = $costEach;
?>

<div class="w-100">
    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <div>
                <div class="modal-close-button">
                </div>
            </div>
        </div>
        <div class="flex-grow text-center">
            <div class="">
                <?= $itemArray->name ?>
            </div>
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div>
        <div class="text-center text-xs font-normal" id="item-quantity">
            <span>
                PRICE (EACH): <i class="fa-solid fa-coins"></i> <?= $itemArray->price ?>
            </span>
        </div>
        <div class="pt-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= $itemArray->icon ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                <?= ucfirst($itemArray->type1) ?>
                            </div>
                            <div class="item-name">
                                <?= ucfirst($itemArray->type2) ?>
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
                    <?= $itemArray->description ?>
                </div>
            </div>
        </div>
        <div class="pl-3 pb-3">
            <div>
                <div class="item-lore">
                    <?= $itemArray->lore ?>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
        <!-- CONTROLES DE QUANTIDADE -->
        <div class="pb-3">
            <div class="text-center pb-3">Choose the quantity:</div>

            <div class="text-center quantity-controller">
                <button class="w-20 rounded bg-surface p-3 qtd-btn" data-change="-10">-10</button>
                <button class="w-20 rounded bg-surface p-3 qtd-btn" data-change="-1">-1</button>

                <span class="w-20 qtd-value" id="qtd-value"><?= $quantity ?></span>

                <button class="w-20 rounded bg-surface p-3 qtd-btn" data-change="1">+1</button>
                <button class="w-20 rounded bg-surface p-3 qtd-btn" data-change="10">+10</button>
            </div>
        </div>
        <div class="pb-3">
            <div class="text-center pb-3">Total Cost:</div>

            <div class="w-100 text-center qtd-value" id="qtd-value">
                <i class="fa-solid fa-coins"></i>
                <?= $costTotal ?>
            </div>
        </div>
        <div class="font-normal rounded bg-surface">
            <div class="d-flex justify-between p-3 cursor-pointer" onclick="closeCommonWindow()">
                <div class="color-blue">
                    Buy
                </div>
                <div class="color-blue"><i class="fa-solid fa-check"></i></div>
            </div>
        </div>
        <div class="pb-3"></div>
        <div class="font-normal rounded bg-surface">
            <div class="d-flex justify-between p-3 cursor-pointer" onclick="closeCommonWindow()">
                <div class="color-red">
                    Cancel
                </div>
                <div class="color-red"><i class="fa-solid fa-xmark"></i></div>
            </div>
        </div>
    </div>
</div>

<style>
    .quantity-controller {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }

    .qtd-value {
        font-weight: bold;
        font-size: 1.1rem;
        color: var(--color-text);
    }
</style>

<style>
    .qtd-btn {
        color: var(--color-text);
        outline: none;
        border: none;
        cursor: pointer;
    }

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