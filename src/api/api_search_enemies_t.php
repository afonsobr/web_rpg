<?php

use TamersNetwork\Helper\Helper;

if ($spawnArray) {
    ?>
    <div style="min-height: 28px">
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="showBattleConfirmation()">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <img class="digimon-image" src="assets/img/digis/<?= $spawnArray->enemy->digimonData->image ?>.gif" style="width: 100%">
                    </div>
                    <div class="d-flex w-100 items-center">
                        <div class="font-normal nowrap pr-3 text-sm">
                            <i class="fa-regular <?= Helper::getEnemyClass($spawnArray->enemy->enemyClass); ?>"></i>
                            <i class="fa-regular <?= Helper::getAttributeIcon($spawnArray->enemy->digimonData->attr); ?>"></i>
                            <i class="fa-regular <?= Helper::getElementIcon($spawnArray->enemy->digimonData->element); ?>"></i>
                        </div>
                        <div class="font-normal pr-3"><?= $spawnArray->enemy->digimonData->name . ' Lv. ' . $spawnArray->enemy->level ?></div>
                    </div>
                    <div class="d-flex justify-center flex-col">
                        <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div hidden class="pb-3">
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between p-3">
                    <div>
                        HP
                    </div>
                    <div>
                        <?= $spawnArray->enemy->maxHp ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Atk
                    </div>
                    <div>
                        <?= $spawnArray->enemy->attack ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Def
                    </div>
                    <div>
                        <?= $spawnArray->enemy->defense ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        StatSTR
                    </div>
                    <div>
                        <?= $spawnArray->enemy->statStr ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="pb-4">
        <div class="rounded bg-surface">
            <div class="d-flex w-100 p-3">
                <div class="d-flex w-100 justify-center items-center" style="min-height: 28px">
                    <div class="font-normal nowrap pr-3">No enemies found!</div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>