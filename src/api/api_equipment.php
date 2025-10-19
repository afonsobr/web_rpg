<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\EnemyRepository;
use TamersNetwork\Repository\EquipmentRepository;
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
    $equipmentRepo = new EquipmentRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);

    // $tamerEquipment = $account->getEquipment($equipmentRepo);

    $return = false;
    if ($action == 'removeEquipment') {
        if (isset($_POST['slotName'])) {
            $slotName = $_POST['slotName'];

            $return = $equipmentRepo->unequipItemSlot($account->id, $slotName);
        }

    } else if ($action == 'equipItem') {
        if (isset($_POST['inventoryId'])) {
            $inventoryId = $_POST['inventoryId'];
            $itemArray = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, $inventoryId);
            $return = $itemArray;

            $return = $equipmentRepo->equipItem($account->id, $itemArray->item->type2, $itemArray->id);
        }
    }

    echo json_encode($return);


} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>