<?php
$locations = array();
$location['FILE ISLAND'] = [
    'Village of Beginnings' =>
        [
            'icon' => 'fa-house-tree',
            'description' => 'A serene meadow dotted with cradles and DigiEggs, where new life quietly begins.',
            'goto' => 'fi_village_of_beginnings'
        ],
    'Tropical Jungle' =>
        [
            'icon' => 'fa-trees',
            'description' => 'A dense, humid jungle filled with towering trees, tangled vines, and endless greenery.',
            'level' => '1 - 5',
            'goto' => 'fi_tropical_jungle'
        ],
    'Faulty Ex Machina' =>
        [
            'icon' => 'fa-gears',
            'description' => 'A massive, decaying factory of rusted gears and silent machines frozen in time.',
            'level' => '6 - 10'
        ],
    'Sewers' =>
        [
            'icon' => 'fa-faucet',
            'description' => 'Dark underground tunnels where dripping water echoes and rusted pipes stretch endlessly.',
            'level' => '11 - 15'
        ],
    'Railroad Plains' =>
        [
            'icon' => 'fa-faucet',
            'description' => 'Vast plains crossed by abandoned tracks and broken railcars, silent under the open sky.',
            'level' => '16 - 20'
        ],
    'Gravel Wasteland' =>
        [
            'icon' => 'fa-faucet',
            'description' => 'A barren land of cracked stone and dust, scattered with jagged rocks and forgotten ruins.',
            'level' => '21 - 25'
        ],
    'Ancient Bone Swamp' =>
        [
            'icon' => 'fa-water',
            'description' => 'A foggy marshland littered with enormous skeletal remains and murky waters.',
            'level' => '26 - 30'
        ],
    'Freezland' =>
        [
            'icon' => 'fa-snowflake',
            'description' => 'A frozen tundra of snowfields and icy peaks, where blizzards never cease.',
            'level' => '31 - 35'
        ],
    'Great Canyon' =>
        [
            'icon' => 'fa-mountain-sun',
            'description' => 'A vast canyon carved by time, with towering cliffs and endless winding paths.',
            'level' => '36 - 40'
        ],
    'Gear Savannah' =>
        [
            'icon' => 'fa-cloud',
            'description' => 'A wide plain where colossal gears rise from the earth among dry grasslands.',
            'level' => '41 - 45'
        ],
    'Logic Volcano' =>
        [
            'icon' => 'fa-volcano',
            'description' => 'A fiery volcano with rivers of lava and trembling ground beneath constant eruptions.',
            'level' => '46 - 50'
        ],
    'Overdell' =>
        [
            'icon' => 'fa-tombstone',
            'description' => 'A fiery volcano with rivers of lava and trembling ground beneath constant eruptions.',
            'level' => '51 - 55'
        ],
];

// $location['None'] = [
//     'Village of Beginnings' =>
//         [
//             'icon' => 'fa-house-tree',
//             'description' => 'A serene meadow dotted with cradles and DigiEggs, where new life quietly begins.',
//             'goto' => 'village_of_beginnings'
//         ],
// ]
?>
<div class="pb-4">
    <div class="map-bg bg-dw rounded p-3">
        <span>
            Digital World
        </span>

    </div>
</div>
<div>
    <?php
    foreach ($location as $mainPlaceName => $mainPlace) {
        echo '<div class="pb-4">';
        echo '  <div class="font-normal text-sm py-1 pl-3">' . $mainPlaceName . '</div>';
        echo '  <div class="rounded bg-surface">';
        $last_key = array_key_last($mainPlace);

        foreach ($mainPlace as $subPlaceName => $subPlace) {
            if (isset($subPlace['goto']))
                echo '<div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap(\'' . $subPlace['goto'] . '\')">';
            else
                echo '<div class="d-flex w-100 p-3">';
            // Icone
            if (true) {
                echo '<div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">';
                if (isset($subPlace['icon']))
                    echo '  <i class="fa-solid ' . $subPlace['icon'] . '"></i>';
                else
                    echo '  <i class="fa-solid fa-lock"></i>';
                echo '</div>';
            }
            // Conteúdo
            if (true) {
                echo '<div class="d-flex w-100 justify-center flex-col">';
                if (true) {
                    echo '<div class="font-normal">';
                    echo $subPlaceName;
                    echo '</div>';
                }
                if (isset($subPlace['description'])) {
                    echo '<div class="text-sm italic">';
                    echo $subPlace['description'];
                    echo '</div>';
                }
                if (isset($subPlace['level'])) {
                    echo '<div class="text-sm">';
                    echo 'Recommended Level: ' . $subPlace['level'];
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
        echo '  </div>';
        echo '</div>';
    }
    ?>
    <div hidden>

        <div class="font-normal text-sm py-1">
            FILE ISLAND
        </div>
        <div class="rounded bg-surface p-3">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">
                        Village of Beginnings
                    </div>
                    <div class="text-sm italic">
                        An Enigmatic Island at the Heart of the Digital World
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 pt-4">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">
                        Native Forest
                    </div>
                    <div class="text-sm italic">
                        A dense forest full of life, with gigantic trees and a peaceful atmosphere
                    </div>
                    <div class="text-sm">
                        Recommended Level: 1 - 5
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div hidden class="pt-4">
        <div class="font-normal text-sm py-1">
            SERVER CONTINENT
        </div>
        <div class="rounded bg-surface p-3">
            <div class="d-flex w-100">
                <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="d-flex w-100 justify-center flex-col">
                    <div class="font-normal">
                        afonsobr
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
</div>