<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\EnemyRepository;

try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $enemyRepo = new EnemyRepository($pdo);
    $account = $accountRepo->findById($_SESSION['account_uuid']);

    // $enemyArray = $enemyRepo->getEnemyById(1);
    $mapIds = ['fi_tropical_jungle' => 1, 'fi_railroad_plains' => 2, 'fi_logic_volcano' => 3];
    $spawnArray = $enemyRepo->getRandomEnemyByMapSpawn($mapIds[$_SESSION['map']]);
    // var_dump($enemyArray);

    $_SESSION['spawnArray'] = $spawnArray;
    $f = basename(__FILE__, '.php'); // Specify the extension to remove

    include $_SERVER['DOCUMENT_ROOT'] . '/src/api/' . $f . '_t.php'; // Use o nome do seu arquivo de template


} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>