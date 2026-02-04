<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Repository\EvolutionRepository;
use TamersNetwork\Repository\InventoryRepository;

try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    $action = $_POST['action'] ?? null;
    if (!$action) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid action.']);
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $digimonRepo = new DigimonRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);

    if ($action == 'selectDataForHatch') {
        $r = false;
        if (isset($_POST['inventoryId'])) {
            $inventoryId = $_POST['inventoryId'];
            $itemArray = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, $inventoryId);
            if ($itemArray) {
                $r = true;
                $_SESSION['data_for_hatch'] = $itemArray;
            }
        }

        echo json_encode($r);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>