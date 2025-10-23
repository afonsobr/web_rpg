<?php
$trainingOptions = [
    [
        'id' => 0,
        'name' => 'Punching Bag (STR)',
        'icon' => 'fa-boxing-glove'
    ],
    [
        'id' => 1,
        'name' => 'Running Track (AGI)',
        'icon' => 'fa-sneaker-running'
    ],
    [
        'id' => 2,
        'name' => 'Rock Pushing (CON)',
        'icon' => 'fa-hill-rockslide'
    ],
    [
        'id' => 3,
        'name' => 'Classroom (INT)',
        'icon' => 'fa-book-open'
    ],
];

shuffle($trainingOptions);
?>
<div class="pb-4">
    <div class="map-bg bg-leomon-gym rounded p-3">
        <span>
            <!-- Leomon's Training Ground -->
        </span>

    </div>
</div>
<?php
echo mapName('Leomon\'s Training Ground');
?>

<div class="">
    <div class="font-normal text-sm py-1 pl-3">
        LEOMON
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Welcome, brave Tamer. Strength is not only measured by power, but by heart. Stand tall, for this is a place where courage is forged. </div>
    </div>
    <div class="pl-3 pr-3 pb-3">
        <div class="description italic">
            Through the Training System, you can temper your Digimon’s body and spirit. Every session builds discipline — and true strength comes only through perseverance. </div>
    </div>
</div>

<?php
echo returnToVBBtn();
?>

<div>
    <div class="pb-3">
        <div class="font-normal text-sm py-1 pl-3">
            TRAINING SYSTEM
        </div>
        <div class="rounded bg-surface">
            <div class="d-flex w-100 flex-col">
                <?php
                foreach ($trainingOptions as $opt) {
                    ?>
                    <div class="d-flex justify-between p-3 cursor-pointer" onclick="training(<?= $opt['id'] ?>)">
                        <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                            <i class="fa-solid <?= $opt['icon'] ?>"></i>
                        </div>
                        <div class="d-flex w-100 items-center justify-between">
                            <div class="item-name">
                                <?= $opt['name'] ?>
                            </div>
                            <div class="item-name">
                                <i class="fa-solid fa-chevron-right"></i>
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