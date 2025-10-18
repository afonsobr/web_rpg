<?php
use TamersNetwork\Helper\Helper;
use TamersNetwork\Model\DigimonData;
// var_dump($digimon->digimonData->traitCommon);

$battleCommands = [
    ['icon' => '1', 'name' => ucwords(strtolower($digimon->digimonData->skillText1)), 'cost' => '0 DS', 'disabled' => true],
    ['icon' => '2', 'name' => ucwords(strtolower($digimon->digimonData->skillText2)), 'cost' => '11 DS', 'disabled' => true],
    ['icon' => '3', 'name' => ucwords(strtolower($digimon->digimonData->skillText3)), 'cost' => '16 DS', 'disabled' => true],
];
$enemyArray = $_SESSION['enemyArray'];
?>
<div class="w-100">
    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <!-- <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-arrow-left"></i></button> -->
        </div>
        <div class="flex-grow text-center">
            Batalha
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 battle-area">
                    <div class="w-50 text-center p-1 digimon-side" id="partner">
                        <img id="partner-img" class="digimon-image flip-x" src="assets/img/digis/<?= $digimon->digimonData->image ?>.gif" alt="">
                        <div class="damage-text" id="damage-text-partner">0</div>
                    </div>
                    <div class="w-50 text-center p-1 digimon-side" id="enemy">
                        <img id="enemy-img" class="digimon-image" src="assets/img/digis/<?= $enemyArray->digimonData->image ?>.gif" alt="">
                        <div class="damage-text" id="damage-text-enemy">0</div>
                    </div>
                </div>
                <div class="d-flex w-100">
                    <div class="w-50 text-center p-1">
                        <div id="partner-hp-back">
                            <div id="partner-hp" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="w-50 text-center p-1">
                        <div id="enemy-hp-back">
                            <div id="enemy-hp" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex w-100 text-xs pb-1">
                    <div class="w-50 text-center p-1">
                        <span id="partner-hp-text">100</span>%
                    </div>
                    <div class="w-50 text-center p-1">
                        <span id="enemy-hp-text">100</span>%
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                BATTLE COMMANDS
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <?php foreach ($battleCommands as $cmd): ?>
                        <div onclick="partnerAttack(<?= $cmd['icon'] ?>)" class="d-flex justify-between p-3 cursor-pointer <?= $cmd['disabled'] ? 'disabled' : '' ?>" id="battle-command-<?= $cmd['icon'] ?>">
                            <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                <i class="fa-solid fa-<?= $cmd['icon'] ?>"></i>
                            </div>
                            <div class="d-flex w-100 items-center justify-between">
                                <div class="item-name"><?= $cmd['name'] ?></div>
                                <div class="item-name text-sm"><?= $cmd['cost'] ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
                            <i class="fa-solid fa-cards-blank"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Card Slash
                            </div>
                            <div class="item-name">
                                10<span class="text-sm"> / 10</span>
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
                </div>
            </div>
        </div>
        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                OTHER COMMANDS
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3 cursor-pointer" onclick="showAbandonBattleConfirmation()">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-person-running-fast"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Run Away from Battle
                            </div>
                            <div class="item-name text-sm">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                ENEMY INFO
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="">
                                <?= $enemyArray->digimonData->name ?>
                                <i class="fa-regular <?= Helper::getEnemyClass($enemyArray->enemyClass); ?>"></i>
                            </div>
                            <div class="item-name">
                                Lv. <?= $enemyArray->level ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= Helper::getAttributeIcon($enemyArray->digimonData->attr); ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Attribute
                            </div>
                            <div class="item-name">
                                <?= $enemyArray->digimonData->attrToDisplay ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid <?= Helper::getElementIcon($enemyArray->digimonData->element); ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Element
                            </div>
                            <div class="item-name">
                                <?= ucfirst($enemyArray->digimonData->element) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div hidden class="pb-3">
            <div class="font-normal text-sm py-1 pl-3">
                ADMIN
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
                                <?= $digimon->attack ?> / <?= $enemyArray->attack ?>
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
                                <?= $digimon->defense ?> / <?= $enemyArray->defense ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                            <i class="fa-solid fa-gauge"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                Battle Rating
                            </div>
                            <div class="item-name">
                                <?= $digimon->battleRating ?> / <?= $enemyArray->battleRating ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #partner-hp-back,
    #enemy-hp-back {
        width: 72px;
        background-color: var(--color-background-canvas);
        height: 5px;
        border: 1px solid var(--color-text);
        margin: 0 auto;
    }

    #partner-hp,
    #enemy-hp {
        width: 100%;
        height: 100%;
        background-color: var(--color-red);
        transition: width 0.6s ease-in-out;
    }
</style>

<style>
    .battle-area {
        position: relative;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
    }

    .digimon-side {
        position: relative;
        width: 50%;
        text-align: center;
    }

    .digimon-image {
        transition: transform 0.3s ease;
    }

    /* ⚡ Animação de ataque do parceiro (da esquerda pra direita) */
    .partner-attack {
        animation: partner-attack-move 0.6s ease forwards;
    }

    @keyframes partner-attack-move {
        0% {
            transform: scaleX(-1) translateX(0);
        }

        50% {
            transform: scaleX(-1) translateX(-15vw);
        }

        100% {
            transform: scaleX(-1) translateX(0);
        }
    }

    /* ⚡ Animação de ataque do inimigo (da direita pra esquerda) */
    .enemy-attack {
        animation: enemy-attack-move 0.6s ease forwards;
    }

    @keyframes enemy-attack-move {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(-15vw);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* 💥 Piscar vermelho no hit */
    .hit {
        animation: hit-flash 0.3s ease;
    }

    @keyframes hit-flash {

        0%,
        100% {
            filter: none;
        }

        50% {
            filter: brightness(2) sepia(1) hue-rotate(-50deg);
        }
    }

    /* 💢 Dano subindo */
    .damage-text {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translateX(-50%);
        color: red;
        font-weight: bold;
        font-size: 20px;
        opacity: 0;
        pointer-events: none;
        text-shadow: rgb(0, 0, 0) 1px 0px 0px, rgb(0, 0, 0) 0.540302px 0.841471px 0px,
            rgb(0, 0, 0) -0.416147px 0.909297px 0px, rgb(0, 0, 0) -0.989992px 0.14112px 0px;
    }

    .damage-rise {
        animation: damage-rise 0.8s ease-out forwards;
    }

    @keyframes damage-rise {
        0% {
            transform: translate(-50%, 0);
            opacity: 1;
        }

        100% {
            transform: translate(-50%, -40px);
            opacity: 0;
        }
    }

    .defeated-image {
        filter: grayscale(1) brightness(0.7);
    }
</style>