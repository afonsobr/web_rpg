<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Repository\EvolutionRepository;

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
    $evolutionRepo = new EvolutionRepository($pdo);
    $account = $accountRepo->findById($_SESSION['account_uuid']);

    if ($action == 'setPartner') {
        $partnerId = (int) $_POST['partnerId'];
        $digimonRepo->setNewPartner($account->id, $partnerId);
        echo json_encode(true);
    } else if ($action == 'trainPartner') {
        $trainingType = (int) $_POST['trainingType'];
        $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);

        $maxTrainingValueArray['rookie'] = 10;
        $maxTrainingValueArray['champion'] = 30;
        $maxTrainingValueArray['ultimate'] = 70;
        $maxTrainingValueArray['mega'] = 99;
        $maxTrainingValueArray['ultra'] = 99;

        $maxTrainingValue = $maxTrainingValueArray[$partner->digimonData->stage];

        $stats = [
            0 => ['name' => 'STR', 'fieldStat' => 'statStr', 'fieldGym' => 'gymStr'],
            1 => ['name' => 'AGI', 'fieldStat' => 'statAgi', 'fieldGym' => 'gymAgi'],
            2 => ['name' => 'CON', 'fieldStat' => 'statCon', 'fieldGym' => 'gymCon'],
            3 => ['name' => 'INT', 'fieldStat' => 'statInt', 'fieldGym' => 'gymInt']
        ];

        // segurança: evita índice inválido
        if (!isset($stats[$trainingType])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid training type.'
            ]);
            exit;
        }

        $statName = $stats[$trainingType]['fieldStat'];
        $gymName = $stats[$trainingType]['fieldGym'];
        $descName = $stats[$trainingType]['name'];

        $oldStatValue = (int) $partner->$statName;
        $newStatValue = $oldStatValue + 1;

        $oldGymValue = (int) $partner->$gymName;
        $newGymValue = $oldGymValue + 1;

        $success = false;
        if ($oldGymValue < $maxTrainingValue) {
            $success = true;
        }
        // Exemplo de chance de falha (30%)

        if ($success) {
            $partner->$statName = $newStatValue;
            $partner->$gymName = $newGymValue;
            $digimonRepo->saveTrainingInformation($partner);

            $result = [
                'success' => true,
                'message' => "Success! Training complete!<br><br>
                {$descName}: {$oldStatValue} <i class='fa-solid fa-arrow-right'></i> {$newStatValue}<br>
                Training Points: {$oldGymValue}/{$maxTrainingValue} <i class='fa-solid fa-arrow-right'></i> {$newGymValue}/{$maxTrainingValue}<br>"
            ];
        } else {
            $result = [
                'success' => false,
                'message' => "Fully trained!<br>
                Your Digimon has mastered this stat.<br>No further improvement possible.<br>"
            ];
        }

        echo json_encode($result);
    } else if ($action == 'evolveDigimon') {
        $lineId = (int) $_POST['lineId'];
        $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);
        $evolutionArray = $evolutionRepo->findEvolutionByLineId($lineId);
        $r = [
            'success' => false,
            'message' => 'Invalid Evolution.'
        ];

        if ($evolutionArray) {
            if ($partner->level < $evolutionArray['level']) {
                $r = [
                    'success' => false,
                    'message' => 'Not enough level to evolve.'
                ];
            } else {
                $partner->level = 1;
                $partner->exp = 0;
                $r = [
                    'success' => true,
                    'message' => 'Evolution successful!'
                ];
                $digimonRepo->saveEvolution($partner, $evolutionArray['to_id']);
            }
        }
        echo json_encode($r);
    }
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>