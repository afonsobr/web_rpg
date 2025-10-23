<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;

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
    $account = $accountRepo->findById($_SESSION['account_uuid']);

    if ($action == 'changeBattleStatus') {
        if (isset($_POST['battleStatus'])) {
            $status = $_POST['battleStatus'];

            if ($status === 'true' || $status === true) {
                $_SESSION['battleStatus'] = true;
            } elseif ($status === 'false' || $status === false) {
                $_SESSION['battleStatus'] = false;
            } else {
                // Valor inválido, não altera a sessão
                error_log("Valor inválido recebido em battleStatus: " . print_r($status, true));
            }
        }
        echo json_encode(['success' => true, 'message' => 'Status de batalha atualizado.']);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Ação de conta desconhecida.']);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>