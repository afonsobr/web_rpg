<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\ItemRepository;
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
    $account = $accountRepo->findById($_SESSION['account_uuid']);
    $itemRepo = new ItemRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    if ($action == 'buyItem') {
        $itemId = (int) $_POST['itemId'];
        $itemQuantity = (int) $_POST['itemQuantity'] ?? 0;
        $itemPrice = (int) $_POST['itemPrice'] ?? 0;
        $itemCost = (int) $_POST['itemCost'] ?? 0;
        $itemArray = $itemRepo->getItem((int) $itemId);
        $r = [
            'success' => false,
            'message' => 'Invalid Item.'
        ];

        if (!$itemArray || $itemQuantity < 1 || $itemPrice <= 0 || $itemCost <= 0) {
            echo json_encode($r);
            exit();
        }

        if (($itemQuantity * $itemPrice != $itemCost) || ($itemPrice != $itemArray->price) || ($itemArray->isPurchasable != 1)) {
            echo json_encode($r);
            exit();
        }

        if ($account->coin < $itemCost) {
            $r['message'] = 'Insuficient Coins.';
            echo json_encode($r);
            exit();
        }

        $r = [
            'success' => true,
            'message' => 'ok'
        ];

        $r['itemArray'] = $itemArray;

        try {
            // 3. Descontar o dinheiro
            $account->addCoin(($itemCost * -1));
            $account->save($accountRepo);

            // 4. Adicionar item ao inventário
            $inventoryRepo->addItem($account->id, $itemArray, $itemQuantity);

            echo json_encode(['status' => 'success', 'message' => 'Item comprado com sucesso!', 'new_balance' => $newBalance]);

        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao processar compra: ' . $e->getMessage()]);
        }


        echo json_encode($r);

    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>