<div class="w-100 d-flex py-2 items-center">
    <div class="text-lg pl-3 pr-3 text-center" style="min-width: 50px">
        <?= $account->level ?>
    </div>
    <div class="w-100 d-flex items-center pr-3">
        <div class="w-50 text-left">
            <div>
                <?= $account->username ?>
            </div>
            <div class="text-xs">
                <?= $account->exp ?>/<?= $account->maxExp ?>
            </div>
        </div>
        <div class="w-50 d-flex justify-around text-sm" style="gap: 5px">
            <div style="d-flex">
                <i class="fa-solid fa-coins"></i> <?= $account->displayCoin ?>
            </div>
            <div style="d-flex">
                <i class="fa-solid fa-gem"></i> <?= $account->cash ?>
            </div>
            <div style="d-flex" hidden>
                <i class="fa-solid fa-bolt"></i> <?= $account->energy ?>
            </div>
        </div>
    </div>
</div>