<?php
// $_SESSION['map'] = null;
?>
<div class="pb-4">
    <div class="map-bg bg-greymon-shop rounded p-3">
        <span>
            <!-- Greymon's Shop -->
        </span>

    </div>
</div>

<div class="">
    <div class="font-normal uppercase py-1 pl-3">
        GREYMON'S SHOP
    </div>
    <div class="font-normal text-sm py-1 pl-3">
        GREYMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Rrrgh! Welcome, tamer! You’ve entered Greymon’s Shop — the forge of champions!
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Every great warrior knows that victory begins before the battle.
            Grab your gear, sharpen your claws, and face the Digital World with pride!
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            My items aren’t cheap, but they’re worth every bit — forged in flame and tested in combat!
        </div>
    </div>
</div>


<?php
echo returnToVBBtn();
?>

<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            SHOP
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <div class="d-flex justify-between p-3 cursor-pointer">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                        <i class="fa-solid fa-file"></i>
                    </div>
                    <div class="d-flex w-100 items-center justify-between">
                        <div class="item-name">
                            Select a Data
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