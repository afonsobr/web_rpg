<?php
use TamersNetwork\Helper\Helper;
?>

<div class="w-100">
    <div class="w-100 d-flex items-center pb-3">
        <div style="width: 50px; text-align: left;">
            <!-- <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-arrow-left"></i></button> -->
        </div>
        <div class="flex-grow text-center">
            Partner Select
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div id="storage-list-container" class="pb-4">
        <?php
        foreach ($digimonList as $digimon) {
            ?>
            <div class="rounded bg-surface p-3 digimon-card cursor-pointer" id="digimon-card-<?= $digimon->id ?>" onclick="selectPartner(<?= $digimon->id ?>)">
                <div class="d-flex w-100 items-center justify-center">
                    Lv. <?= $digimon->level ?>
                </div>
                <div class="d-flex w-100 items-center justify-center">
                    <img class="digimon-image" src="assets/img/digis/<?= $digimon->digimonData->image ?>.gif" alt="">
                </div>
                <div class="d-flex w-100 items-center justify-center digimon-name">
                    <?= $digimon->digimonData->name ?>
                </div>
                <div class="dc-attr-icon">
                    <i class="fa-regular <?= Helper::getAttributeIcon($digimon->digimonData->attr); ?>"></i>
                </div>
                <div class="dc-element-icon">
                    <i class="fa-regular <?= Helper::getElementIcon($digimon->digimonData->element); ?>"></i>
                </div>
            </div>
            <?php
        }
        ?>
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

    #storage-list-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 15px;
        overflow: auto;
        height: 50vh;
    }

    #storage-list-container>div {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .digimon-card {
        position: relative;
    }

    .digimon-name {
        display: block;
        max-width: 100%;
        /* garante que respeite o card */
        white-space: nowrap;
        /* impede quebrar em várias linhas */
        overflow: hidden;
        /* corta o que passar */
        text-overflow: ellipsis;
        /* adiciona "..." */
        text-align: center;
    }

    .dc-attr-icon {
        position: absolute;
        top: 2.75rem;
        right: 0.75rem;
    }

    .dc-element-icon {
        position: absolute;
        top: 4.75rem;
        right: 0.75rem;
    }
</style>