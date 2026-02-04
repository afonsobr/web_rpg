<?php
// $_SESSION['map'] = null;
?>
<div class="pb-4">
    <div class="map-bg bg-vb rounded p-3">
        <span>
            <!-- Village of Beginnings -->
        </span>

    </div>
</div>

<div class="">
    <div class="font-normal uppercase py-1 pl-3">
        Village of Beginnings
    </div>
</div>

<div>
    <div class="pb-4">
        <div class="rounded bg-surface">
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_jijimons_house')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-house-chimney"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Jijimon's House</div>
                </div>
            </div>
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_dojo')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-vihara"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Antylamon's Dojo</div>
                </div>
            </div>
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_leomons_gym')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-campground"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Leomon's Training Ground</div>
                </div>
            </div>
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_greymons_shop')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-shop"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Greymon's Shop</div>
                </div>
            </div>
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_guardromons_shack')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-industry-windows"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Guardromon's Shack</div>
                </div>
            </div>
            <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap('fi_vb_birdramons_inn')">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-house-chimney-window"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">Birdramon's Inn</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
echo returnToDigitalWorldBtn();
?>