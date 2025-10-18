<?php

use TamersNetwork\Helper\Helper;

if ($enemyArray) {
    ?>
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="showBattleConfirmation()">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <img class="digimon-image" src="assets/img/digis/<?= $enemyArray->digimonData->image ?>.gif" style="width: 100%">
                    </div>
                    <div class="d-flex w-100 items-center">
                        <div class="font-normal nowrap pr-3 text-sm">
                            <i class="fa-regular <?= Helper::getEnemyClass($enemyArray->enemyClass); ?>"></i>
                            <i class="fa-regular <?= Helper::getAttributeIcon($enemyArray->digimonData->attr); ?>"></i>
                            <i class="fa-regular <?= Helper::getElementIcon($enemyArray->digimonData->element); ?>"></i>
                        </div>
                        <div class="font-normal pr-3"><?= $enemyArray->digimonData->name . ' Lv. ' . $enemyArray->level ?></div>
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
                        <?= $enemyArray->maxHp ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Atk
                    </div>
                    <div>
                        <?= $enemyArray->attack ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Def
                    </div>
                    <div>
                        <?= $enemyArray->defense ?>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        StatSTR
                    </div>
                    <div>
                        <?= $enemyArray->statStr ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer">
                    <div class="d-flex w-100 items-center justify-center">
                        <div class="font-normal pr-3">No enemies found</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>