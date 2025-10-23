<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\InventoryRepository;

// Toda a lógica de "Chef" que vimos antes fica aqui.
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

    $inventoryId = $_POST['inventoryId'] ?? null;
    if (!$inventoryId || !is_numeric($inventoryId)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'ID do Item/Inventário inválido.']);
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);

    $itemArray = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, (int) $inventoryId);
    if (!$itemArray) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Item não encontrado.']);
        exit();
    }

    if ($action == 'toggleItemProtection') {
        if ($itemArray->isBlocked == false) {
            $itemArray->isBlocked = true;
        } else {
            $itemArray->isBlocked = false;
        }
        $inventoryRepo->saveInventorySlot($account->id, $itemArray);
        echo json_encode(true);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>