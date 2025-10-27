<?php
use TamersNetwork\Helper\Helper;
?>

<!-- 1. O wrapper principal agora é um container flex em coluna que ocupa toda a altura -->
<div class="w-100 d-flex flex-col h-100" id="storage-list">

    <!-- 2. O header não encolhe -->
    <div class="w-100 d-flex items-center pb-3" style="flex-shrink: 0;">
        <div style="width: 50px; text-align: left;">
            <!-- Botão de voltar pode ser adicionado aqui se necessário -->
        </div>
        <div class="flex-grow text-center">
            Partner Select
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <!-- 3. O container da lista vai crescer e ter overflow -->
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
    /* O container da lista agora cresce para preencher o espaço e tem scroll interno */
    #storage-list-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 15px;

        /* flex-grow: 1; */
        /* <<-- Ponto Chave 1: Faz a lista ocupar o espaço restante */
        overflow-y: auto;
        /* <<-- Ponto Chave 2: Adiciona a barra de rolagem vertical */
        min-height: 0;
        /* <<-- Ponto Chave 3: Crucial para o overflow funcionar corretamente em flex children */

        border-top: 1px solid var(--color-text-muted);
        border-bottom: 1px solid var(--color-text-muted);
        padding-top: 10px;
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
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
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

    /* Estilo opcional para a barra de rolagem */
    /* #storage-list-container::-webkit-scrollbar {
        width: 8px;
    }

    #storage-list-container::-webkit-scrollbar-track {
        background: var(--color-background-surface-1);
        border-radius: 4px;
    }

    #storage-list-container::-webkit-scrollbar-thumb {
        background-color: var(--color-text-muted);
        border-radius: 4px;
    } */
</style>