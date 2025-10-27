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
                        <?= $account->username ?>
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
    <div class="pt-4">
        <div class="font-normal text-sm py-1 pl-3">
            PARTNER
        </div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 cursor-pointer" onclick="openDigimonWindow(<?= $partner->id ?>)">
                    <div class="w-50 text-center p-1">
                        <img class="digimon-image" src="assets/img/digis/<?= $partner->digimonData->image ?>.gif" alt="">
                    </div>
                    <div class="d-flex w-50 items-center justify-center flex-col">
                        <div class="font-normal">
                            <?= $partner->digimonData->name ?>
                        </div>
                        <div class="text-sm">
                            Lv. <?= $partner->level ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex justify-between p-3 cursor-pointer" onclick="openSelectPartnerWindow()">
                <div>
                    Change Partner
                </div>
                <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
            </div>
        </div>
    </div>
    <div hidden class="pt-4">
        <div class="font-normal text-sm py-1 pl-3">
            ADVENTURE PASS
        </div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="d-flex justify-between p-3">
                        <div>
                            Level
                        </div>
                        <div>
                            1
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3">
                        <div>
                            Exp
                        </div>
                        <div>
                            0/10
                        </div>
                    </div>
                    <div class="d-flex justify-between p-3 cursor-pointer">
                        <div>
                            Check Rewards
                        </div>
                        <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex justify-between p-3 cursor-pointer" onclick="openSelectPartnerWindow()">
                <div>
                    Check Rewards
                </div>
                <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
            </div>
        </div>
        <div hidden class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between overflow-auto p-3">
                    <div>
                        <table class="table text-center">
                            <tr>
                                <td class="p-3" style="">Prizes</td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td class="p-3" style="">Level</td>
                                <td class="p-3" style="">1</td>
                                <td class="p-3" style="">2</td>
                                <td class="p-3" style="">3</td>
                                <td class="p-3" style="">4</td>
                                <td class="p-3" style="">5</td>
                                <td class="p-3" style="">6</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-4">
        <div class="font-normal text-sm py-1 pl-3">
            MAIL
        </div>
        <div class="pb-3">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 flex-col">
                    <div class="justify-between p-3 text-center">
                        <div>
                            No new messages
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex justify-between p-3 cursor-pointer" onclick="openMail()">
                <div>
                    Check Mail
                </div>
                <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
            </div>
        </div>
        <div hidden class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between overflow-auto p-3">
                    <div>
                        <table class="table text-center">
                            <tr>
                                <td class="p-3" style="">Prizes</td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                                <td class="p-3" style=""><img src="assets/img/digis/groundramon.gif" alt=""></td>
                            </tr>
                            <tr>
                                <td class="p-3" style="">Level</td>
                                <td class="p-3" style="">1</td>
                                <td class="p-3" style="">2</td>
                                <td class="p-3" style="">3</td>
                                <td class="p-3" style="">4</td>
                                <td class="p-3" style="">5</td>
                                <td class="p-3" style="">6</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div hidden class="pt-4">
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