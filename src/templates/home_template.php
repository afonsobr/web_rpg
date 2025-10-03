<div>
    <div>
        <div class="font-normal text-sm py-1 pl-3">
            TAMER
        </div>
        <div class="rounded bg-surface p-3">
            <div class="d-flex w-100">
                <div class="d-flex w-50 items-center justify-center flex-col text-xl">
                    <?= $account->level ?>
                </div>
                <div class="d-flex w-50 items-center justify-center flex-col">
                    <div class="font-normal">
                        <?= $account->username ?> [<?= $_SESSION['account_uuid'] ?>]
                    </div>
                    <div class="text-sm">
                        Robust Tamer
                    </div>
                    <div class="text-sm">
                        [Guild Name]
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-4 cursor-pointer" onclick="openDigimonWindow(1)">
        <div class="font-normal text-sm py-1 pl-3">
            PARTNER
        </div>
        <div class="rounded bg-surface p-3">
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
    <div class="pt-4">
        <div class="font-normal text-sm py-1 pl-3">
            FAST INFORMATION
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between p-3">
                    <div>
                        Bits
                    </div>
                    <div>
                        3000
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Cash
                    </div>
                    <div>
                        1500
                    </div>
                </div>
                <div class="d-flex justify-between p-3">
                    <div>
                        Energy
                    </div>
                    <div>
                        100/100
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>