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
    $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);
    $enemyArray = $_SESSION['enemyArray'];

    if ($_SESSION['inBattle'] !== true) {
        echo json_encode(false);
        exit;
    }

    if ($action == 'attack') {
        if (isset($_POST['skill'])) {
            $skillOption = $_POST['skill'];

            if ($skillOption < 1 || $skillOption > 3) {
                $skillOption = 1;
            }
        }

        echo json_encode(true);
        exit;
    }

    /*
     * FUNÇÃO DE ATAQUE
     *
     * NOTA: Eu movi esta função para fora do 'if ($action === ...)'
     * É uma prática melhor definir funções no escopo principal ou, idealmente,
     * como um método privado da sua classe (ex: private function performAttack(...))
     *
     * Eu também adicionei mais verificações (?? 1) para evitar erros caso
     * 'attack', 'defense' ou 'maxHp' não existam, e adicionei os nomes
     * ao log, o que ajuda muito no front-end.
     */
    if (!function_exists('performAttack')) {
        function performAttack($attacker, $defender, $iid)
        {
            // Garante que os valores são numéricos e evita erros
            $atk = $attacker->attack ?? 1;
            $def = $defender->defense ?? 1;
            $maxHp = $defender->maxHp ?? 1;

            // Fórmula de dano
            $baseDmg = pow($atk, 2) * 0.1 / max(1, $def); // max(1, ...) evita divisão por zero
            $dmg = max(1, floor($baseDmg)); // Garante pelo menos 1 de dano

            // Aplica o dano
            $defender->currentHp -= $dmg;
            if ($defender->currentHp < 0) {
                $defender->currentHp = 0;
            }

            // Retorna o log desta ação
            return [
                'attackerName' => $iid ?? 'Attacker', // Útil para o log no front-end
                // 'defenderName' => $iid ?? 'Defender', // Útil para o log no front-end
                'damage' => $dmg,
                'newHp' => $defender->currentHp,
                'newHpPercent' => round(($defender->currentHp / max(1, $maxHp)) * 100), // max(1, ...) evita divisão por zero
                'isFainted' => ($defender->currentHp <= 0) // Informa se o defensor desmaiou
            ];
        }
    }


    if ($action === 'battleTurns') {
        // Garante que ambos os dados existem
        if (!$partner || !$enemyArray) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing battle participants.'
            ]);
            exit;
        }

        // Determina a ordem com base na velocidade
        $partnerSpeed = $partner->speed ?? 0;
        $enemySpeed = $enemyArray->speed ?? 0;

        // Pequeno fator aleatório para desempate natural
        $partnerSpeed += mt_rand(0, 5);
        $enemySpeed += mt_rand(0, 5);

        $log = [];
        $firstAttacker = 0; // 0 = Partner, 1 = Enemy
        $turnResult = null; // Para armazenar o resultado de cada ataque

        if ($partnerSpeed >= $enemySpeed) {
            $firstAttacker = 0; // Partner ataca primeiro

            // 1. Partner ataca Inimigo
            $turnResult = performAttack($partner, $enemyArray, 0);
            $log[] = $turnResult;

            // 2. Inimigo ataca Partner (APENAS se o inimigo ainda estiver vivo)
            if ($turnResult['isFainted'] === false) {
                $log[] = performAttack($enemyArray, $partner, 1);
            }

        } else {
            // *** ESTE É O BLOCO QUE FALTAVA ***
            $firstAttacker = 1; // Inimigo ataca primeiro

            // 1. Inimigo ataca Partner
            $turnResult = performAttack($enemyArray, $partner, 1);
            $log[] = $turnResult;

            // 2. Partner ataca Inimigo (APENAS se o partner ainda estiver vivo)
            if ($turnResult['isFainted'] === false) {
                $log[] = performAttack($partner, $enemyArray, 0);
            }
        }

        // Verifica se a batalha terminou após a troca de ataques
        $battleOver = ($partner->currentHp <= 0 || $enemyArray->currentHp <= 0);
        $winner = null;
        if ($battleOver) {
            $winner = ($partner->currentHp > 0) ? 'partner' : 'enemy';
        }

        $_SESSION['enemyArray'] = $enemyArray;

        // Envia a resposta JSON completa
        echo json_encode([
            'success' => true,
            'data' => [
                'sequence' => $firstAttacker, // Quem atacou primeiro (0 = partner, 1 = enemy)
                'log' => $log,               // Array com os 1 ou 2 ataques que ocorreram
                'battleOver' => $battleOver,      // true/false, informa se a batalha acabou
                'winner' => $winner,            // 'partner' ou 'enemy', se a batalha acabou

                // É bom enviar o estado final para atualizar a UI
                'partnerState' => [
                    'currentHp' => $partner->currentHp,
                    'maxHp' => $partner->maxHp,
                    'hpPercent' => round(($partner->currentHp / max(1, $partner->maxHp)) * 100)
                ],
                'enemyState' => [
                    'currentHp' => $enemyArray->currentHp,
                    'maxHp' => $enemyArray->maxHp,
                    'hpPercent' => round(($enemyArray->currentHp / max(1, $enemyArray->maxHp)) * 100)
                ]
            ]
        ]);
        exit;
    }

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo "Ocorreu um erro ao carregar os dados: " . $e->getMessage();
    error_log($e->getMessage()); // Loga o erro para você ver depois
}
?>