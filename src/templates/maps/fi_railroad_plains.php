<?php
// $_SESSION['map'] = null;
?>
<div class="pb-4">
    <div class="map-bg bg-railroad-plains rounded p-3">
        <span>
            <!-- Tropical Jungle -->
        </span>
    </div>
</div>




<?php
echo mapName('Railroad Plains');
echo findEnemiesBtn();
echo enemiesTable();
echo returnToDigitalWorldBtn();
?>


<style>
    .map-bg span {
        /* color: #d9d9d9; */
        /* background: #e8e8e8; */
        /* text-shadow: -1px -1px 1px rgba(255, 255, 255, .1), 1px 1px 1px rgba(0, 0, 0, .5); */
    }
</style>