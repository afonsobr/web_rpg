<?php
// $_SESSION['map'] = null;
?>
<div class="pb-4">
    <div class="map-bg bg-birdramon-inn rounded p-3">
        <span>
        </span>
    </div>
</div>

<div class="">
    <div class="font-normal py-1 pl-3">
        BIDRAMONS'S INN
    </div>
    <div class="font-normal text-sm py-1 pl-3">
        BIRDRAMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Ah, a weary traveler! Welcome to Birdramon’s Inn. Whether you need a place to rest or a new ally to join your ranks, you’ve come to the right place. Make yourself at home, Tamer! </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Ready to expand your team? Access the Incubation Terminal to process your gathered data. Turn raw code into life and prepare your new Digimon for the battles ahead! </div>
    </div>
</div>

<?php
echo returnToVBBtn();
?>

<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            HP AND DS RESTORATION SYSTEM
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between p-3 cursor-pointer">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <i class="fa-solid fa-bed"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between" onclick="restInDigimonInn()">
                        <div class="item-name">
                            Sleep and Full Recover <small class="opacity-50">(10s)</small>
                        </div>
                        <div class="item-name">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .description {
        padding-left: 10px;
        border-left: 2px solid var(--color-text);
    }
</style>