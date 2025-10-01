<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
// use TamersNetwork\Repository\DigimonRepository;

// Toda a lógica de "Chef" que vimos antes fica aqui.
try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    // $digimonRepo = new DigimonRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    // $digimons = $digimonRepo->findAllByOwnerUuid($account->uuid);
    // $partner = $digimons[0] ?? null;

    // A "mágica" está aqui. Em vez de mostrar na tela, a saída do include
    // será a resposta do seu fetch.
    include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/home_template.php'; // Use o nome do seu arquivo de template

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>