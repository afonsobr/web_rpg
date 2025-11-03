<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Repository\EquipmentRepository;

try {
    if (!isset($_SESSION['account_uuid'])) {
        http_response_code(401); // Unauthorized
        echo "Usuário não autenticado.";
        exit();
    }

    $pdo = DatabaseManager::getConnection();
    $accountRepo = new AccountRepository($pdo);
    $digimonRepo = new DigimonRepository($pdo);
    $equipmentRepo = new EquipmentRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    $digimon = $digimonRepo->getPartnerByAccountId((int) $account->id);
    $tamerEquipment = $account->getEquipment($equipmentRepo);

    // $digimon->currentHp = $digimon->maxHp;
    if ($digimon->currentHp <= 0) {
        // $digimon->currentHp = $digimon->maxHp;
        // $digimon->currentDs = $digimon->maxDs;

        $digimon->currentHp = 1;
    }

    // Verifica equipamento pra recuperar
    $aurasIds = [
        4201 => 10,
        4202 => 20,
        4203 => 40,
        4204 => 50,
        4205 => 80,
        4206 => 100,
    ];

    if ($tamerEquipment->aura != null && isset($tamerEquipment->aura->item)) {
        $itemId = $tamerEquipment->aura->item->itemId;

        // Verifica se o item da aura está na lista
        if (isset($aurasIds[$itemId])) {
            $percent = $aurasIds[$itemId];

            $hpPercent = floor(($percent / 100) * $digimon->maxHp);
            $dsPercent = floor(($percent / 100) * $digimon->maxDs);

            // Recupera HP até a % se estiver abaixo
            if ($digimon->currentHp < $hpPercent) {
                $digimon->currentHp = $hpPercent;
            }

            // Recupera DS até a % se estiver abaixo
            if ($digimon->currentDs < $dsPercent) {
                $digimon->currentDs = $dsPercent;
            }
        }
    }

    $digimon->save($digimonRepo);
    include $_SERVER['DOCUMENT_ROOT'] . '/src/templates/battle_window_template.php'; // Use o nome do seu arquivo de template

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>