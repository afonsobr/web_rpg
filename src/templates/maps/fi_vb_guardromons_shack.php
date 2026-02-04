<?php
// $_SESSION['map'] = null;
?>

<div class="pb-4">
    <div class="map-bg bg-guardromon-shack rounded p-3">
    </div>
</div>

<div class="">
    <div class="font-normal py-1 pl-3">
        GUARDROMON'S SHACK
    </div>
    <div class="font-normal text-sm py-1 pl-3">
        GUARDROMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            System check... all green! Welcome to Guardromon’s Shack, tamer!
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            This is where machines come to life and ideas turn into solid metal.
            If you bring the right materials, I can help you craft useful equipment, upgrade components, and maybe... something special.
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Efficiency is key — no wasted effort, no wasted bolts.
            So, ready to build something powerful?
        </div>
    </div>
</div>

<?php
echo returnToVBBtn();
?>

<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            CRAFT SYSTEM
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