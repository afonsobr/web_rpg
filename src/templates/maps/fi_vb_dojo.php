<?php

use TamersNetwork\Helper\Helper;
use TamersNetwork\Repository\EvolutionRepository;
// $_SESSION['map'] = null;
$mapName = 'Antylamon\'s Dojo';
?>
<div class="pb-4">
    <div class="map-bg bg-dojo rounded p-3">
        <span>
            <!-- Antylamon's Dojo -->
        </span>

    </div>
</div>
<?php
echo mapName($mapName);
?>
<div class="">
    <div class="font-normal text-sm py-1 pl-3">
        ANTYLAMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Welcome, Tamer... I am Antylamon, Guardian of the Digievolution Dojo.
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Within these sacred halls, your Digimon may transcend its limits and walk new evolutionary paths.
            Each training, each decision, shapes the future form of your partner.
            Here, you can explore multiple branches of evolution — each leading to a different destiny.
        </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Choose wisely... for every evolution tells a story.
        </div>
    </div>
</div>
<?php
echo returnToVBBtn();
?>
<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            EVOLUTION SYSTEM
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <?php
                $evolutionRepo = new EvolutionRepository($pdo);
                $availableEvos = $evolutionRepo->findEvolution($partner->digimonData->digimonId);
                if ($availableEvos) {
                    foreach ($availableEvos as $possibleEvo) {
                        // var_dump($possibleEvo['to_id']);
                        $possibleDigimon = $digimonRepo->getDigimonData($possibleEvo['to_id']);
                        ?>
                        <div class="d-flex w-100 p-3 cursor-pointer" onclick="confirmEvolution(<?= $possibleEvo['id'] ?>)">
                            <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                                <img class="digimon-image" src="assets/img/digis/<?= $possibleDigimon->image ?>.gif" style="width: 100%">
                            </div>
                            <div class="d-flex w-100 items-center">
                                <div class="font-normal nowrap pr-3 text-sm">
                                    <i class="fa-regular <?= Helper::getAttributeIcon($possibleDigimon->attr); ?>"></i>
                                    <i class="fa-regular <?= Helper::getElementIcon($possibleDigimon->element); ?>"></i>
                                </div>
                                <div class="pr-3"><span class="font-normal"><?= $possibleDigimon->name ?></span>
                                    at Lv.
                                    <span class="font-normal"><?= $possibleEvo['level'] ?></span>
                                    <div class="text-xs">
                                        Requires 0 BIT
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-center flex-col">
                                <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="d-flex justify-between p-3 cursor-pointer">
                        <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                            <i class="fa-solid fa-empty-set"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                No Evolution available
                            </div>
                            <div class="item-name">

                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
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