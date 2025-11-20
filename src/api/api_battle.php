<?php
// Este arquivo é o alvo do seu fetch. É um ponto de entrada completo.

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/bootstrap.php';

use TamersNetwork\Database\DatabaseManager;
use TamersNetwork\Repository\AccountRepository;
use TamersNetwork\Repository\DigimonRepository;
use TamersNetwork\Helper\BattleHelper;
use TamersNetwork\Repository\MailRepository;
use TamersNetwork\Repository\EquipmentRepository;
use TamersNetwork\Repository\InventoryRepository;
use TamersNetwork\Model\Account;

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
function performAttack($attacker, $defender, $iid, $skillOption = 1, $battleCard = null)
{
    // Garante que os valores são numéricos e evita erros
    $atk = $attacker->attack ?? 1;
    $def = $defender->defense ?? 1;
    $maxHp = $defender->maxHp ?? 1;
    $criticalSwitch = false;
    $traitSwitch = false;
    $drillSwitch = false;
    $cardConsumeSwitch = false;

    // Trait de Redução de Dano
    if ($defender->digimonData->traitCommon) {
        foreach ($defender->digimonData->traitCommon as $t) {
            if ($t->type == 'atk') {
                if (mt_rand(0, 100) <= $defender->traitRate) {
                    $def = $def * (100 + $t->multiplier) / 100;
                    $traitSwitch = true;
                }
            }
        }
    }

    // Fórmula de dano
    $baseDmg = pow($atk, 2) * 0.1 / max(1, $def); // max(1, ...) evita divisão por zero
    $dmg = max(1, floor($baseDmg)); // Garante pelo menos 1 de dano

    // Multiplicador da Skill
    if ($iid == 0) {
        $dmg = processPartnerSkill($attacker, $skillOption, $dmg);
    }

    // Vantagens
    $em = BattleHelper::checkAttributeAdvantage($attacker->digimonData->attr, $defender->digimonData->attr);
    $dmg = floor($em * $dmg);

    // Trait de Aumentar Crítico (Sniping)
    if ($attacker->digimonData->traitCommon) {
        foreach ($attacker->digimonData->traitCommon as $t) {
            if ($t->type == 'cr') {
                if (mt_rand(0, 100) <= $attacker->traitRate) {
                    $attacker->criticalRate += ($t->multiplier);
                    $traitSwitch = true;
                }
            }
        }
    }

    // Critical Damage
    if (mt_rand(0, 100) <= $attacker->criticalRate) {
        // Trait de Amplification
        if ($attacker->digimonData->traitCommon) {
            foreach ($attacker->digimonData->traitCommon as $t) {
                if ($t->type == 'cd') {
                    if (mt_rand(0, 100) <= $attacker->traitRate) {
                        $attacker->criticalDamage += ($t->multiplier / 100);
                        $traitSwitch = true;
                    }
                }
            }
        }

        $dmg = floor($dmg * $attacker->criticalDamage);
        $criticalSwitch = true;
    }

    // Trait de Aumento de Dano
    if ($attacker->digimonData->traitCommon) {
        foreach ($attacker->digimonData->traitCommon as $t) {
            if ($t->type == 'atk') {
                if (mt_rand(0, 100) <= $attacker->traitRate) {
                    $dmg = $dmg * (100 + $t->multiplier) / 100;
                    $traitSwitch = true;
                }
            }
        }
    }

    // Card de Dano
    if ($iid == 0 && $battleCard) {
        if ($battleCard->item->type2 == 'damage') {
            $dmg += floor($dmg * $battleCard->item->multiplier / 100);
            $cardConsumeSwitch = true;
        } else if ($battleCard->item->type2 == 'rk') {
            $drillSwitch = true;
            $chances = [300, 500, 700];
            shuffle($chances);
            $dmg += floor($dmg * $chances[0] / 100);
            $cardConsumeSwitch = true;
        }

        if (in_array($battleCard->item->itemId, [2, 4])) {
            $drillSwitch = true;
        }
    }

    // Card de Defesa
    if ($iid == 1 && $battleCard) {
        if ($battleCard->item->type2 == 'defense') {
            $dmg -= floor($dmg * $battleCard->item->multiplier / 100);
            $cardConsumeSwitch = true;
        }
    }

    // Aplica o dano
    $dmg = max(1, floor($dmg)); // Garante pelo menos 1 de dano
    $dmg = min(floor($dmg), $defender->maxHp); // Garante pelo menos 1 de dano

    // Verifica se deu miss
    $related = $defender->battleRating / $attacker->battleRating;
    $missed = 500 * $related;

    if ($drillSwitch == false) {
        if (mt_rand(1, 10000) <= $missed) {
            $dmg = 0;
            $criticalSwitch = 0;
            $traitSwitch = 0;
        }
    }

    $defender->currentHp -= $dmg;
    if ($defender->currentHp < 0) {
        $defender->currentHp = 0;
    }

    $defender->getHpPercent();
    $attacker->getHpPercent();

    // Retorna o log desta ação
    return [
        'attackerName' => $iid ?? 'Attacker', // Útil para o log no front-end
        // 'defenderName' => $iid ?? 'Defender', // Útil para o log no front-end
        'damage' => $dmg,
        'battleCardView' => $battleCard,
        'battleCard' => $cardConsumeSwitch,
        'critical' => $criticalSwitch,
        'trait' => $traitSwitch,
        'newHp' => $defender->currentHp,
        'newHpPercent' => round(($defender->currentHp / max(1, $maxHp)) * 100), // max(1, ...) evita divisão por zero
        'isFainted' => ($defender->currentHp <= 0),
        'attackerArray' => ['hpPercent' => $attacker->hpPercent, 'currentHp' => $attacker->currentHp, 'currentDs' => $attacker->currentDs],
        'defenderArray' => ['hpPercent' => $defender->hpPercent, 'currentHp' => $defender->currentHp, 'currentDs' => $defender->currentDs],
    ];
}

function processPartnerSkill($attacker, $skillOption, $dmg)
{
    // Define custo e multiplicador padrão
    $skillData = [
        1 => ['cost' => 0, 'multiplier' => 1.0],
        2 => ['cost' => 11, 'multiplier' => 1.5],
        3 => ['cost' => 16, 'multiplier' => 2.0],
    ];

    // Garante que a skill exista (fallback para 1)
    $skill = $skillData[$skillOption] ?? $skillData[1];

    // Verifica se tem DS suficiente
    if ($attacker->currentDs >= $skill['cost']) {
        // Consome o DS
        $attacker->currentDs -= $skill['cost'];

        // Calcula o dano com o multiplicador
        $dmg = floor($dmg * $skill['multiplier']);
    } else {
        // DS insuficiente → reduz dano e gera aviso
        $dmg = floor($dmg * 0.5);
    }

    return $dmg;
}

function processBattleCard(Account $account, $log, $inventoryRepository)
{
    if ($log['battleCardView'] && $log['battleCard'] == true) {
        $log['battleCardView']->consumeItem();
        $log['battleCardView']->save($account, $inventoryRepository);
    }

    return $log;
}

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
    $equipmentRepo = new EquipmentRepository($pdo);
    $inventoryRepo = new InventoryRepository($pdo);

    $account = $accountRepo->findById($_SESSION['account_uuid']);
    $partner = $digimonRepo->getPartnerByAccountId((int) $account->id);
    $tamerEquipment = $account->getEquipment($equipmentRepo);
    $partner->calculateFinalStats($tamerEquipment);
    $tamerStats = $tamerEquipment->getAllStatsBonus();

    $spawnArray = $_SESSION['spawnArray'];
    $enemyArray = $_SESSION['spawnArray']->enemy;

    if ($_SESSION['inBattle'] !== true) {
        echo json_encode(false);
        exit;
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

        if (isset($_POST['partnerSkillNumber'])) {
            $skillOption = (int) $_POST['partnerSkillNumber'];

            if ($skillOption < 1 || $skillOption > 3) {
                $skillOption = 1;
            }
        }

        // Determina a ordem com base na velocidade
        $partnerSpeed = $partner->speed ?? 0;
        $enemySpeed = $enemyArray->speed ?? 0;

        // Pequeno fator aleatório para desempate natural
        $partnerSpeed += mt_rand(0, 5);
        $enemySpeed += mt_rand(0, 5);

        // Battle Card
        $battleCardId = $_SESSION['battleCard'] ?? 0;
        $battleCard = null;
        if ($battleCardId > 0) {
            $battleCard = $inventoryRepo->getSingleInventoryItemByInventoryId($account->id, $battleCardId);
            if ($battleCard->quantity <= 0) {
                $battleCard = null;
            }
        }

        // Ajustes finais
        $log = [];
        $firstAttacker = 0; // 0 = Partner, 1 = Enemy
        $turnResult = null; // Para armazenar o resultado de cada ataque

        if ($partnerSpeed >= $enemySpeed) {
            $firstAttacker = 0; // Partner ataca primeiro

            // 1. Partner ataca Inimigo
            $turnResult = performAttack($partner, $enemyArray, 0, $skillOption, $battleCard);
            $turnResult = processBattleCard($account, $turnResult, $inventoryRepo);

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
                $log[] = performAttack($partner, $enemyArray, 0, $skillOption, $battleCard);
            }
        }

        // Verifica se a batalha terminou após a troca de ataques
        $battleOver = ($partner->currentHp <= 0 || $enemyArray->currentHp <= 0);
        $winner = null;
        if ($battleOver) {
            $winner = ($partner->currentHp > 0) ? 'partner' : 'enemy';
        }

        $reward = null;
        // Recompensas
        if ($battleOver && $winner == 'partner') {
            $reward = array();
            $reward['tamerExp'] = mt_rand(3, 5) + $tamerStats['tamerexp'];
            $reward['digimonExp'] = $spawnArray->expReward + floor($tamerStats['digimonexp'] * $spawnArray->expReward / 100);
            $reward['bits'] = $spawnArray->bitReward + floor($tamerStats['bits'] * $spawnArray->bitReward / 100);

            $pLvlUp = $partner->addExp($reward['digimonExp'], $tamerEquipment);

            $tLvlUp = $account->addExp($reward['tamerExp']);
            $account->addCoin($reward['bits']);
            $account->save($accountRepo);

            if ($tLvlUp || $pLvlUp) {
                // Instancie o repositório apenas se houver um level up
                $mailRepo = new MailRepository($pdo);

                if ($tLvlUp) {
                    $msg = "<p>Hello, {$account->username}!</p>
                    <p>Congratulations! You have reached Tamer level <strong>{$account->level}</strong>!</p>
                    <p>Keep progressing on your journey!</p>";
                    $mailRepo->sendSystemMail($account->id, 'Tamer Level Up!', $msg);
                }

                if ($pLvlUp) {
                    $msg = "<p>Hello, {$account->username}!</p>
                    <p>Congratulations! Your Partnermon {$partner->digimonData->name} reached level <strong>{$partner->level}</strong>!</p>
                    <p>Keep progressing on your journey!</p>";
                    $mailRepo->sendSystemMail($account->id, 'Partner Level Up!', $msg);
                }
            }
        }

        $partner->save($digimonRepo);
        $_SESSION['spawnArray']->enemy = $enemyArray;

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
                ],
                'reward' => $reward
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