<?php
use TamersNetwork\Helper\Helper;
use TamersNetwork\Model\DigimonData;
// var_dump($digimon->digimonData->traitCommon);

function showTraits(DigimonData $digimonData)
{
    $c = 0;
    foreach ($digimonData->traitCommon as $t): ?>
        <div class="p-3">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                    <i class="fa-solid <?= $t->icon ?>"></i>
                </div>
                <div class="d-flex w-100 justify-between flex-col">
                    <div class="item-name font-normal">
                        <?= $t->name ?>
                    </div>
                    <div class="">
                        <?= $t->description ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $c++;
    endforeach;

    foreach ($digimonData->traitSpecific as $t): ?>
        <div class="p-3">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                    <i class="fa-solid <?= $t->icon ?>"></i>
                </div>
                <div class="d-flex w-100 justify-between flex-col">
                    <div class="item-name font-normal">
                        <?= $t->name ?>
                    </div>
                    <div class="">
                        <?= str_replace(['%CHANCE%', '%MULTIPLIER%'], [$t->chance, $t->multiplier], $t->description); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php $c++;
    endforeach;

    if ($c == 0) {
        ?>
        <div class="p-3">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                    <i class="fa-solid fa-empty-set"></i>
                </div>
                <div class="d-flex w-100 justify-between flex-col">
                    <div class="item-name font-normal">
                        None
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}


?>
<div class="w-100">

    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <!-- <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-arrow-left"></i></button> -->
        </div>
        <div class="flex-grow text-center">
            <?= $digimon->nickname ?>
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div class="pb-3" hidden>
        <div class="w-100 d-flex items-center text-center dw-btn-stage" style="gap: 10px">
            <div class="text-sm rounded bg-surface-1 w-100 py-4 px-1 active" onclick="">
                ROOKIE
            </div>
            <div class="text-sm rounded bg-surface w-100 py-4 px-1 active" onclick="">
                CHAMPION
            </div>
            <div class="text-sm rounded bg-surface w-100 py-4 px-1" onclick="">
                ULTIMATE
            </div>
            <div class="text-sm rounded bg-surface w-100 py-4 px-1" onclick="">
                MEGA
            </div>
        </div>
    </div>
    <div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100">
                    <div class="w-50 text-center p-1">
                        <img class="digimon-image" src="assets/img/digis/<?= $digimon->digimonData->image ?>.gif" alt="">
                    </div>
                    <div class="d-flex w-50 items-center justify-center flex-col" style="gap: 4px">
                        <div class="font-normal">
                            <?= $digimon->digimonData->name ?>
                        </div>
                        <div class="text-sm">
                            Lv. <?= $digimon->level ?>
                        </div>
                        <div class="text-xs">
                            [<?= strtoupper($digimon->digimonData->stage) ?>]
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                BASIC INFO
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-heart"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                HP
                            </div>
                            <div class="item-name">
                                <?= $digimon->currentHp ?><span class="text-sm"> / <?= $digimon->maxHp ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-atom"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                DS
                            </div>
                            <div class="item-name">
                                <?= $digimon->currentDs ?><span class="text-sm"> / <?= $digimon->maxDs ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-star-christmas"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                EXP
                            </div>
                            <div class="item-name">
                                <?= $digimon->exp ?><span class="text-sm"> / <?= Helper::nFormat($digimon->maxExp) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                BASIC CHARACTERISTICS
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col text-center">
                    <div class="d-flex justify-between p-3">
                        <div class="w-50">
                            <?= $digimon->statStr ?><br>
                            STR
                        </div>
                        <div class="w-50">
                            <?= $digimon->statAgi ?><br>
                            AGI
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="w-50">
                            <?= $digimon->statCon ?><br>
                            CON
                        </div>
                        <div class="w-50">
                            <?= $digimon->statInt ?><br>
                            INT
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                BATTLE CHARACTERISTICS <span class="cursor-pointer" onclick="toggleAditionalInfo()"><i class="fa-solid fa-info-circle"></i></span>
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-hand-back-fist"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Attack
                            </div>
                            <div class="item-name">
                                <?= $digimon->attack ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-shield"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Defense
                            </div>
                            <div class="item-name">
                                <?= $digimon->defense ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Speed
                            </div>
                            <div class="item-name">
                                <?= $digimon->speed ?>
                            </div>
                        </div>
                    </div>
                    <div id="aditional-info">
                        <div class="d-flex justify-between p-3">
                            <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                            <div class="d-flex w-100 items-center justify-between">
                                <div class="item-name">
                                    Trait Activation Rate
                                </div>
                                <div class="item-name">
                                    <?= $digimon->traitRate ?>%
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-between p-3">
                            <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                <i class="fa-solid fa-percent"></i>
                            </div>
                            <div class="d-flex w-100 items-center justify-between">
                                <div class="item-name">
                                    Critical Rate
                                </div>
                                <div class="item-name">
                                    <?= $digimon->criticalRate ?>%
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-between p-3">
                            <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                <i class="fa-solid fa-explosion"></i>
                            </div>
                            <div class="d-flex w-100 items-center justify-between">
                                <div class="item-name">
                                    Critical Damage
                                </div>
                                <div class="item-name">
                                    x<?= $digimon->criticalDamage ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                ADITIONAL INFO
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= Helper::getAttributeIcon($digimon->digimonData->attr); ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Attribute
                            </div>
                            <div class="item-name">
                                <?= $digimon->digimonData->attrToDisplay ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= Helper::getElementIcon($digimon->digimonData->element); ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Element
                            </div>
                            <div class="item-name">
                                <?= ucfirst($digimon->digimonData->element) ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= Helper::getFamilyIcon($digimon->digimonData->family); ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Family
                            </div>
                            <div class="item-name">
                                <?= $digimon->digimonData->family ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Size
                            </div>
                            <div class="item-name">
                                <?= $digimon->size ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                TRAITS
            </div>
            <div class="rounded bg-surface">
                <?php
                showTraits($digimon->digimonData);
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    #aditional-info {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transition: max-height 0.5s ease, opacity 0.5s ease;
    }

    #aditional-info.show {
        max-height: 500px;
        /* valor maior que a altura máxima do conteúdo */
        opacity: 1;
    }
</style>