<?php

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

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $digimonRepo = new DigimonRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    $digimon = $digimonRepo->getPartnerByAccountId((int) $account->id);

    // $digimon->currentHp = $digimon->maxHp;
    if ($digimon->currentHp <= 0) {
        $digimon->currentHp = 1;
    }
    $digimon->save($digimonRepo);
    include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/battle_window_template.php'; // Use o nome do seu arquivo de template

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>