<?php
use TamersNetwork\Helper\Helper;
?>
<div class="w-100">
    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-arrow-left"></i></button>
        </div>
        <div class="flex-grow text-center">
            NoName
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="pb-3">
        <div class="rounded bg-surface">
            <div class="d-flex w-100">
                <div class="w-50 text-center p-1">
                    <img src="assets/img/digis/agumon.gif" alt="">
                </div>
                <div class="d-flex w-50 items-center justify-center flex-col">
                    <div class="font-normal">
                        Agumon
                    </div>
                    <div class="text-sm">
                        Lv.100
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
                            3000/3000
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
                            3000/3000
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
                            3000/3000
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-3">
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

    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            BASIC CHARACTERISTICS
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col text-center">
                <div class="d-flex justify-between p-3">
                    <div class="w-50">
                        150<br>
                        STR
                    </div>
                    <div class="w-50">
                        500<br>
                        AGI
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div class="w-50">
                        150<br>
                        CON
                    </div>
                    <div class="w-50">
                        500<br>
                        INT
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            BATTLE CHARACTERISTICS
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
                            300
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
                            300
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
                            300
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
                        <i class="fa-solid <?= Helper::getAttributeIcon('va'); ?>"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Attribute
                        </div>
                        <div class="item-name">
                            Vaccine
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                        <i class="fa-solid <?= Helper::getElementIcon('fire'); ?>"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Element
                        </div>
                        <div class="item-name">
                            Fire
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                        <i class="fa-solid <?= Helper::getFamilyIcon('NSp'); ?>"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Family
                        </div>
                        <div class="item-name">
                            NSp
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
            <div class="p-3 cursor-pointer">
                <div class="d-flex w-100">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <i class="fa-solid fa-cards-blank"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Twin Spear
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>