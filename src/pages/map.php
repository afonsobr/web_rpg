<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;

// Toda a lógica de "Chef" que vimos antes fica aqui.
try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    if (isset($_GET['mapName'])) {
        $mapName = htmlspecialchars(strip_tags($_GET['mapName']), ENT_QUOTES, 'UTF-8');
        $_SESSION['map'] = $mapName;
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $digimonRepo = new DigimonRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);

    $map = 'hub';
    if (isset($_SESSION['map'])) {
        $map = $_SESSION['map'];
    }
    $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);

    // Reset - descomente para resetar
    // $_SESSION['map'] = 'hub';

    include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/maps/' . $map . '.php'; // Use o nome do seu arquivo de template

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}

function returnToDigitalWorldBtn()
{
    return '    
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap(\'hub\')">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3"> <i class="fa-solid fa-planet-ringed"></i></div>
                    <div class="d-flex w-100 justify-center flex-col">
                        <div class="font-normal">Return to Digital World</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}

function returnToVBBtn()
{
    return '    
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap(\'fi_village_of_beginnings\')">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3"> <i class="fa-solid fa-house-tree"></i></div>
                    <div class="d-flex w-100 justify-center flex-col">
                        <div class="font-normal">Return to Village of Beginnings</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}

function findEnemiesBtn()
{
    return '    
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="searchForEnemies()" id="search-enemies-btn">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3"> <i class="fa-solid fa-radar"></i></div>
                    <div class="d-flex w-100 justify-center flex-col">
                        <div class="font-normal">Analyze and search for enemies</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}

function enemiesTable()
{
    return '<div id="enemies-table">
    </div>';

    return '    
    <div>
        <div class="pb-4">
            <div class="rounded bg-surface">
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap(\'hub\')">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3"> 
                        <img src="assets/img/digis/agumon.gif" style="width: 100%">
                    </div>
                     <div class="d-flex w-100 items-center">
                        <div class="font-normal nowrap pr-3"><i class="fa-solid fa-b"></i><i class="fa-regular fa-syringe"></i><i class="fa-regular fa-fire"></i></div>
                        <div class="font-normal pr-3">Agumon Warmode Lv. 12 </div>
                    </div>
                    <div class="d-flex justify-center flex-col">
                        <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
                    </div>
                </div>
                <div class="d-flex w-100 p-3 cursor-pointer" onclick="loadMap(\'hub\')">
                    <div class="d-flex items-center justify-center flex-col text-xl icon-div pr-3"> 
                        <img src="assets/img/digis/metalgreymon.gif" style="width: 100%">
                    </div>
                    <div class="d-flex w-100 items-center">
                        <div class="font-normal nowrap pr-3"><i class="fa-solid fa-e"></i><i class="fa-regular fa-virus"></i><i class="fa-regular fa-water"></i></div>
                        <div class="font-normal pr-3">MetalGreymon Warmode Lv. 12 </div>
                    </div>
                    <div class="d-flex justify-center flex-col">
                        <div class="font-normal"><i class="fa-solid fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    ';
}

function mapName($name)
{
    return '
    <div class="">
        <div class="font-normal uppercase py-1 pl-3">
            ' . $name . '
        </div>
    </div>';
}
?>