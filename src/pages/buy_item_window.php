<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Repository\InventoryRepository;
use TamersNetwork\Repository\ItemRepository;

// Toda a lógica de "Chef" que vimos antes fica aqui.
try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    // 2️⃣ Pega e valida o ID do Digimon
    $itemId = $_GET['itemId'] ?? null;
    if (!$itemId || !is_numeric($itemId)) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'ID do Item inválido.']);
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $itemRepo = new ItemRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    // $digimons = $digimonRepo->findAllByOwnerUuid($account->uuid);
    // $partner = $digimons[0] ?? null;

    $itemArray = $itemRepo->getItem((int) $itemId);
    if (!$itemArray) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Item não encontrado.']);
        exit();
    }

    include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/shop/buy_item_window_template.php'; // Use o nome do seu arquivo de template

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>