<?php
use TamersNetwork\Helper\Helper;
?>

<div class="w-100 d-flex flex-col h-100" id="storage-list">

    <div class="w-100 d-flex items-center pb-3" style="flex-shrink: 0;">
        <div style="width: 50px; text-align: left;">
            <button id="modal-close-btn" class="modal-close-button" onclick="document.getElementById('btn-home').click();"><i class="fa-solid fa-chevron-left"></i></button>
        </div>
        <div class="flex-grow text-center">
            Mail List
        </div>
        <div style="width: 50px; text-align: right;">
        </div>
    </div>

    <div>
        <div class="pb-3">
            <div hidden class="font-normal text-sm py-1 pl-3">
                MAIL LIST
            </div>
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <?php
                    if (!empty($mailList)) {
                        foreach ($mailList as $mail) {
                            ?>
                            <div class="d-flex justify-between p-3 cursor-pointer">
                                <div class="d-flex items-center justify-center flex-col icon-div pr-3">
                                    <?= $mail->isRead ? '<i class="fa-solid fa-envelope-open"></i>' : '<i class="fa-solid fa-envelope"></i>' ?>
                                </div>
                                <div class="d-flex w-100 items-center justify-between">
                                    <div class="item-name">
                                        <?= $mail->subject ?>
                                        <div class="text-xs">From: <?= $mail->fromName ?></div>
                                    </div>
                                    <div class="text-sm">
                                        <?= date('d/m/y', $mail->sentAt) ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="d-flex p-3">
                            <div class="d-flex text-center justify-center">
                                Your Mail Box is empty!
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>