<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\InventoryRepository;

// Definir o tipo de resposta padrão para esta API
header('Content-Type: application/json');

try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Usuário não autenticado.']);
        exit();
    }

    // 1. Validar a Ação
    $action = $_POST['action'] ?? null;
    if (empty($action)) { // Usar empty() é um pouco mais robusto
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Nenhuma ação especificada.']);
        exit();
    }

    // 2. Carregar dependências
    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    if (!$account) {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Conta de usuário não encontrada.']);
        session_destroy(); // Limpa a sessão inválida
        exit();
    }

    // 3. Verificar Pré-condições (Estar em Batalha)
    if ($_SESSION['inBattle'] !== true) {
        http_response_code(403); // Forbidden / Conflict
        echo json_encode(['error' => 'Você não está em batalha no momento.']);
        exit;
    }

    // 4. Executar Ações (roteamento)
    switch ($action) {
        case 'selectBattleCard':
            // Sanitizar a entrada antes de usá-la
            $inventoryId = filter_var($_POST['inventoryId'] ?? null, FILTER_VALIDATE_INT);

            if ($inventoryId === false || $inventoryId < 0) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID de item inválido.']);
                exit;
            }

            if ($inventoryId === 0) {
                $_SESSION['battleCard'] = null;
                echo json_encode(false);
                exit;
            }

            // Query segura (como você já fez, usando $account->id)
            $itemArray = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, $inventoryId);

            if (empty($itemArray)) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Item não encontrado no seu inventário.']);
                exit;
            }

            // Salva o ID sanitizado na sessão
            $_SESSION['battleCard'] = $inventoryId;

            // Retorna o item (sucesso)
            http_response_code(200); // OK
            echo json_encode($itemArray);
            break;

        // case 'outraAcao':
        // ...
        // break;

        default:
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Ação desconhecida ou não implementada.']);
            break;
    }

} catch (Exception $e) {
    // Log detalhado para o servidor
    error_log("Erro em battle_api.php (Action: $action): " . $e->getMessage());

    // Resposta genérica para o usuário (NUNCA vaze $e->getMessage())
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Ocorreu um erro interno no servidor.']);
}
?>