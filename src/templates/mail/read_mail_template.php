<?php
// use TamersNetwork\Helper\Helper;
$mailRepo->markAsRead($mail->id, $account->id);
?>

<script>openMailList()</script>

<div class="w-100 d-flex flex-col h-100" id="storage-list">
    <div class="w-100 d-flex items-center pb-3" style="flex-shrink: 0;">
        <div style="width: 50px; text-align: left;">
        </div>
        <div class="flex-grow text-center">
            <?= $mail->subject ?>
        </div>
        <div style="width: 50px; text-align: right;">
            <button id="modal-close-btn" class="modal-close-button"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <div id="storage-list-container">
        <div>
            <div class="pb-3">
                <div class="font-normal text-sm py-1 pl-3">
                    From: <?= $mail->fromName ?>
                </div>
                <div class="font-normal text-sm py-1 pl-3">
                    Sent at: <?= date('d/m/y', $mail->sentAt) ?>, <?= date('H:i:s', $mail->sentAt) ?>
                </div>
                <div class="font-normal text-sm py-1 pl-3 pb-4">
                    Subject: <?= $mail->subject ?>
                </div>
                <div class="text-sm py-1 pl-3">
                    <?= $mail->message ?>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-3"></div>
    <div class="rounded bg-surface">
        <div class="d-flex justify-between p-3 cursor-pointer" onclick="closeCommonWindow()">
            <div>
                Close
            </div>
            <div class="font-normal"><i class="fa-solid fa-xmark"></i></div>
        </div>
    </div>
</div>

<style>
    /* O container da lista agora cresce para preencher o espaço e tem scroll interno */
    #storage-list-container {
        flex-grow: 1;
        /* <<-- Ponto Chave 1: Faz a lista ocupar o espaço restante */
        overflow-y: auto;
        /* <<-- Ponto Chave 2: Adiciona a barra de rolagem vertical */
        min-height: 0;
        /* <<-- Ponto Chave 3: Crucial para o overflow funcionar corretamente em flex children */

        border-top: 1px solid var(--color-text-muted);
        border-bottom: 1px solid var(--color-text-muted);
        padding-top: 10px;
    }
</style>