<?php
session_start();

// --- CONFIGURAÇÃO E DADOS ---

$CLASSES = [
    'guerreiro' => [
        'name' => 'Guerreiro',
        'hp' => 200,
        'str' => 15,
        'int' => 0,
        'dex' => 5,
        'icon' => '🛡️',
        'desc' => 'Tanque robusto. Aguenta muito dano.'
    ],
    'mago' => [
        'name' => 'Mago',
        'hp' => 90,
        'str' => 0,
        'int' => 15,
        'dex' => 6,
        'icon' => '🔮',
        'desc' => 'Canhão de vidro. Dano explosivo.'
    ],
    'arqueiro' => [
        'name' => 'Arqueiro',
        'hp' => 100,
        'str' => 8,
        'int' => 0,
        'dex' => 10,
        'icon' => '🏹',
        'desc' => 'Dano crítico alto e rápido.'
    ],
    'assassino' => [
        'name' => 'Assassino',
        'hp' => 90,
        'str' => 12,
        'int' => 0,
        'dex' => 12,
        'icon' => '🗡️',
        'desc' => 'Mestre da esquiva e letal.'
    ]
];

$ENEMIES = [
    ['Rato Gigante', 'Slime', 'Morcego'],
    ['Goblin', 'Esqueleto', 'Lobo'],
    ['Orc', 'Bruxa', 'Fantasma'],
    ['Dragão', 'Demônio', 'Golem']
];

$ITEMS = [
    ['name' => 'Poção Peq. Vida', 'type' => 'consumable', 'cost' => 15, 'effect' => 'heal', 'value' => 50, 'desc' => 'Cura 50 HP.'],
    ['name' => 'Poção Méd. Vida', 'type' => 'consumable', 'cost' => 25, 'effect' => 'heal', 'value' => 150, 'desc' => 'Cura 150 HP.'],
    ['name' => 'Poção Grd. Vida', 'type' => 'consumable', 'cost' => 35, 'effect' => 'heal', 'value' => 300, 'desc' => 'Cura 300 HP.'],
    ['name' => 'Espada de Ferro', 'type' => 'weapon', 'cost' => 50, 'stat' => 'str', 'value' => 3, 'desc' => '+3 Força.'],
    ['name' => 'Cajado Antigo', 'type' => 'weapon', 'cost' => 50, 'stat' => 'int', 'value' => 3, 'desc' => '+3 Intel.'],
    ['name' => 'Adaga Leve', 'type' => 'weapon', 'cost' => 50, 'stat' => 'dex', 'value' => 3, 'desc' => '+3 Destreza.'],
    ['name' => 'Armadura Couro', 'type' => 'armor', 'cost' => 40, 'stat' => 'max_hp', 'value' => 20, 'desc' => '+20 Vida Máx.'],
    ['name' => 'Livro de Ferro', 'type' => 'armor', 'cost' => 40, 'stat' => 'max_hp', 'value' => 20, 'desc' => '+20 Vida Máx.'],
    ['name' => 'Anel da Força', 'type' => 'accessory', 'cost' => 100, 'stat' => 'str', 'value' => 5, 'desc' => 'Raro. +5 Força.'],
    ['name' => 'Amuleto Arcano', 'type' => 'accessory', 'cost' => 100, 'stat' => 'int', 'value' => 5, 'desc' => 'Raro. +5 Intel.'],
];

// --- LÓGICA BACKEND ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'restart') {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['class']) && !isset($_SESSION['game'])) {
        $selectedClass = $CLASSES[$_POST['class']];
        $_SESSION['game'] = [
            'player' => [
                'class' => $selectedClass['name'],
                'hp' => $selectedClass['hp'],
                'max_hp' => $selectedClass['hp'],
                'str' => $selectedClass['str'],
                'int' => $selectedClass['int'],
                'dex' => $selectedClass['dex'],
                'gold' => 0,
                'inventory' => []
            ],
            'floor' => 1,
            'phase' => 'combat_start',
            'log' => [],
            'enemy' => null,
            'loot_options' => [],
            'shop_items' => []
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_SESSION['game']) && isset($_POST['action'])) {
        $game = &$_SESSION['game'];
        $action = $_POST['action'];

        if ($action === 'fight' && $game['phase'] === 'combat_start') {
            $tier = min(floor(($game['floor'] - 1) / 5), 3);
            $enemyName = $ENEMIES[$tier][array_rand($ENEMIES[$tier])];
            $scale = 1 + ($game['floor'] * 0.1);
            $enemy = ['name' => $enemyName, 'hp' => floor(50 * $scale), 'max_hp' => floor(50 * $scale), 'dmg' => floor(5 * $scale)];
            $log = [];
            $log[] = "<div class='text-center py-2 mb-2 bg-gray-800 rounded border border-gray-700 text-xs md:text-sm'><span class='text-yellow-400 font-bold'>ANDAR {$game['floor']}</span><br>Um <span class='text-red-400'>{$enemy['name']}</span> apareceu!</div>";
            $player = &$game['player'];
            while ($player['hp'] > 0 && $enemy['hp'] > 0) {
                $pDmg = floor(($player['str'] + ($player['dex'] * 0.5) + ($player['int'] * 0.5)) * ((rand(0, 100) < min(50, $player['dex'] * 2)) ? 1.5 : 1));
                $enemy['hp'] -= $pDmg;
                $log[] = "<div class='flex justify-between hover:bg-white/5 p-1 rounded border-b border-gray-800/50 text-xs'><span>Você atacou:</span> <span class='text-blue-300'>{$pDmg}</span></div>";
                if ($enemy['hp'] <= 0)
                    break;
                if (rand(0, 100) < min(40, $player['dex'])) {
                    $log[] = "<div class='flex justify-between p-1 rounded text-gray-400 text-xs'><span>Inimigo:</span> <span class='text-green-400'>ESQUIVA</span></div>";
                } else {
                    $player['hp'] -= $enemy['dmg'];
                    $log[] = "<div class='flex justify-between p-1 rounded text-gray-400 text-xs'><span>Inimigo:</span> <span class='text-red-400'>-{$enemy['dmg']} HP</span></div>";
                }
            }
            if ($player['hp'] <= 0) {
                $game['phase'] = 'game_over';
                $log[] = "<div class='text-center mt-4 text-red-600 font-bold uppercase border-t border-gray-700 pt-2'>Você Morreu</div>";
            } else {
                $goldDrop = rand(10, 30) * $game['floor'];
                $player['gold'] += $goldDrop;
                $log[] = "<div class='text-center mt-4 text-green-400 font-bold border-t border-gray-700 pt-2'>VITÓRIA (+{$goldDrop} G)</div>";
                $game['loot_options'] = generateUniqueLootOptions($game['floor']);
                $game['phase'] = 'upgrade';
            }
            $game['log'] = $log;
        }

        if ($action === 'pick_upgrade' && $game['phase'] === 'upgrade') {
            if (isset($game['loot_options'][$_POST['choice']])) {
                applyItem($game['player'], $game['loot_options'][$_POST['choice']]);
                $game['log'][] = "<div class='bg-purple-900/30 p-2 rounded text-center border border-purple-500/30 my-2 text-xs'>Obteve: " . $game['loot_options'][$_POST['choice']]['name'] . "</div>";
            }
            if ($game['floor'] % 5 === 0) {
                $game['phase'] = 'shop';
                $tempItems = $ITEMS;
                shuffle($tempItems);
                $game['shop_items'] = array_slice($tempItems, 0, 3);
            } else {
                $game['floor']++;
                $game['phase'] = 'combat_start';
            }
        }

        if ($action === 'buy_item' && $game['phase'] === 'shop') {
            $idx = $_POST['item_index'];
            if (isset($game['shop_items'][$idx]) && $game['player']['gold'] >= $game['shop_items'][$idx]['cost']) {
                $game['player']['gold'] -= $game['shop_items'][$idx]['cost'];
                applyItem($game['player'], $game['shop_items'][$idx]);
                unset($game['shop_items'][$idx]);
                $game['log'][] = "<div class='text-yellow-300 text-center my-1 text-xs'>Comprou item!</div>";
            }
        }

        if ($action === 'refresh_shop' && $game['phase'] === 'shop') {
            if ($game['player']['gold'] >= 50) {
                $game['player']['gold'] -= 50;
                $tempItems = $ITEMS;
                shuffle($tempItems);
                $game['shop_items'] = array_slice($tempItems, 0, 3);
                $game['log'][] = "<div class='text-blue-300 text-center my-1 italic text-xs'>Loja atualizada (-50 G)</div>";
            }
        }

        if ($action === 'exit_shop' && $game['phase'] === 'shop') {
            $game['floor']++;
            $game['phase'] = 'combat_start';
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

function generateUniqueLootOptions($floor)
{
    global $ITEMS;
    $opts = [];
    $names = [];
    $att = 0;
    while (count($opts) < 3 && $att < 50) {
        $att++;
        if (rand(0, 100) < 40)
            $cand = $ITEMS[array_rand($ITEMS)];
        else {
            $s = ['str', 'int', 'dex', 'max_hp'];
            $st = $s[array_rand($s)];
            $cand = ['name' => "Treino " . strtoupper($st), 'type' => 'upgrade', 'stat' => $st, 'value' => ($st == 'max_hp' ? 20 : 2), 'desc' => 'Melhora status.'];
        }
        if (!in_array($cand['name'], $names)) {
            $opts[] = $cand;
            $names[] = $cand['name'];
        }
    }
    return $opts;
}

function applyItem(&$p, $i)
{
    if ($i['type'] == 'consumable' && $i['effect'] == 'heal')
        $p['hp'] = min($p['max_hp'], $p['hp'] + $i['value']);
    elseif (isset($i['stat'])) {
        $p[$i['stat']] += $i['value'];
        if ($i['stat'] == 'max_hp')
            $p['hp'] += $i['value'];
    }
    if ($i['type'] != 'upgrade' && $i['type'] != 'consumable') {
        if (!isset($p['inventory'][$i['name']]))
            $p['inventory'][$i['name']] = 0;
        $p['inventory'][$i['name']]++;
    }
}

function getItemDataByName($n)
{
    global $ITEMS;
    foreach ($ITEMS as $i)
        if ($i['name'] === $n)
            return $i;
    return ['name' => $n, 'desc' => '???', 'type' => 'misc'];
}
$game = $_SESSION['game'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dungeon Mobile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #0f172a;
            color: #e2e8f0;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
            touch-action: manipulation;
        }

        .layout-grid {
            display: flex;
            flex-direction: column;
            height: 100dvh;
            width: 100vw;
        }

        @media (min-width: 1024px) {
            .layout-grid {
                display: grid;
                grid-template-columns: 280px 1fr 280px;
            }
        }

        .glass-panel {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .custom-scroll {
            -webkit-overflow-scrolling: touch;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }

        #tooltip {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            display: none;
            width: 200px;
        }

        .mobile-modal {
            transition: transform 0.3s ease-in-out;
        }

        .mobile-modal.hidden-modal {
            transform: translateY(100%);
        }

        .mobile-modal.show-modal {
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <div id="tooltip" class="hidden lg:block bg-black border border-gray-500 rounded-lg p-3 shadow-2xl">
        <div id="tt-title" class="font-bold text-white mb-1"></div>
        <div id="tt-desc" class="text-xs text-gray-300"></div>
        <div id="tt-type" class="text-[10px] text-gray-500 mt-2 uppercase text-right"></div>
    </div>

    <?php if (!$game): ?>
        <div class="h-[100dvh] w-full flex flex-col items-center justify-center bg-slate-900 p-4 overflow-y-auto">
            <h1 class="text-4xl lg:text-5xl font-bold text-purple-500 mb-6 tracking-widest text-center">DUNGEON<br>CORE</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 w-full max-w-6xl">
                <?php foreach ($CLASSES as $key => $class): ?>
                    <form method="POST" class="w-full">
                        <input type="hidden" name="class" value="<?= $key ?>">
                        <button class="glass-panel w-full p-4 rounded hover:bg-white/5 active:bg-purple-900/30 border-l-4 border-purple-500/50 flex flex-row lg:flex-col items-center gap-4 transition h-full">
                            <div class="text-4xl lg:text-5xl"><?= $class['icon'] ?></div>
                            <div class="text-left lg:text-center flex-1">
                                <h3 class="text-lg font-bold text-white"><?= $class['name'] ?></h3>
                                <p class="text-xs text-gray-400 leading-tight"><?= $class['desc'] ?></p>
                                <div class="flex gap-2 text-[10px] mt-2 opacity-70">
                                    <span class="text-red-300">HP:<?= $class['hp'] ?></span>
                                    <span class="text-blue-300">STR:<?= $class['str'] ?></span>
                                    <span class="text-yellow-300">DEX:<?= $class['dex'] ?></span>
                                </div>
                            </div>
                        </button>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <?php
        // CORREÇÃO DO ERRO DE ARRAY
        // Busca o ícone da classe atual de forma segura
        $currentIcon = '👤';
        foreach ($CLASSES as $c) {
            if ($c['name'] === $game['player']['class']) {
                $currentIcon = $c['icon'];
                break;
            }
        }
        ?>
        <div class="layout-grid relative">

            <div class="lg:hidden h-14 bg-gray-900 border-b border-gray-700 flex items-center justify-between px-4 z-30 shrink-0">
                <div class="flex items-center gap-2">
                    <span class="text-2xl"><?= $currentIcon ?></span>
                    <div class="flex flex-col">
                        <div class="w-24 bg-gray-800 h-2 rounded-full overflow-hidden mt-1">
                            <div class="bg-red-600 h-full" style="width: <?= ($game['player']['hp'] / $game['player']['max_hp']) * 100 ?>%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400"><?= floor($game['player']['hp']) ?>/<?= $game['player']['max_hp'] ?> HP</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-yellow-400 font-bold text-sm">💰 <?= $game['player']['gold'] ?></span>
                    <button onclick="toggleInventory()" class="bg-gray-800 p-2 rounded text-white border border-gray-600 active:bg-gray-700 relative">
                        🎒
                        <?php if (count($game['player']['inventory']) > 0): ?>
                            <span class="absolute -top-1 -right-1 bg-red-500 w-3 h-3 rounded-full border border-gray-900"></span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <aside class="hidden lg:flex glass-panel border-r border-gray-700 flex-col p-6 z-10">
                <div class="text-center mb-6 pb-6 border-b border-gray-700/50">
                    <div class="text-5xl mb-2"><?= $currentIcon ?></div>
                    <h2 class="text-2xl font-bold text-white"><?= $game['player']['class'] ?></h2>
                    <div class="text-xs bg-purple-900/50 text-purple-200 px-2 py-1 rounded inline-block mt-2">Nível <?= floor($game['floor'] / 2) + 1 ?></div>
                </div>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-xs mb-1 font-bold text-gray-400"><span>VIDA</span> <span><?= floor($game['player']['hp']) ?>/<?= $game['player']['max_hp'] ?></span></div>
                        <div class="w-full bg-gray-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-red-600 h-full transition-all" style="width: <?= ($game['player']['hp'] / $game['player']['max_hp']) * 100 ?>%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2 bg-black/20 p-3 rounded text-sm">
                        <div class="flex justify-between"><span>⚔️ Força</span> <span class="text-white font-bold"><?= $game['player']['str'] ?></span></div>
                        <div class="flex justify-between"><span>🔮 Intel</span> <span class="text-white font-bold"><?= $game['player']['int'] ?></span></div>
                        <div class="flex justify-between"><span>🦵 Destreza</span> <span class="text-white font-bold"><?= $game['player']['dex'] ?></span></div>
                    </div>
                    <div class="bg-yellow-500/10 border border-yellow-500/20 p-3 rounded text-center">
                        <div class="text-2xl font-bold text-yellow-400">💰 <?= $game['player']['gold'] ?></div>
                    </div>
                </div>
            </aside>

            <main class="flex flex-col h-full bg-gray-900 relative overflow-hidden">
                <div class="flex-1 overflow-y-auto custom-scroll p-4 lg:p-6 space-y-1 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]" id="gamelog">
                    <?php foreach ($game['log'] as $entry): ?>
                        <div class="text-sm font-mono text-gray-300"><?= $entry ?></div>
                    <?php endforeach; ?>
                    <div class="h-4"></div>
                </div>

                <div class="h-auto min-h-[180px] lg:h-80 shrink-0 bg-gray-800 border-t-4 border-gray-700 p-3 lg:p-4 shadow-2xl z-20 pb-safe">
                    <div class="h-full">
                        <?php if ($game['phase'] === 'combat_start'): ?>
                            <form method="POST" class="h-full flex items-center justify-center">
                                <input type="hidden" name="action" value="fight">
                                <button class="w-full lg:w-auto bg-red-900/90 hover:bg-red-800 active:scale-95 text-white text-lg lg:text-xl font-bold py-6 px-4 lg:px-16 rounded-xl border-b-4 border-red-700 shadow-lg uppercase tracking-widest flex items-center justify-center gap-4 transition-all">
                                    <span class="text-2xl">⚔️</span>
                                    <span>Explorar Andar <?= $game['floor'] ?></span>
                                </button>
                            </form>
                        <?php elseif ($game['phase'] === 'upgrade'): ?>
                            <div class="h-full flex flex-col">
                                <h3 class="text-center text-green-400 font-bold mb-2 uppercase text-xs tracking-widest">Escolha sua recompensa</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 flex-grow overflow-y-auto">
                                    <?php foreach ($game['loot_options'] as $idx => $loot): ?>
                                        <form method="POST" class="h-full">
                                            <input type="hidden" name="action" value="pick_upgrade">
                                            <input type="hidden" name="choice" value="<?= $idx ?>">
                                            <button class="w-full h-full bg-gray-700 hover:bg-green-900/40 border border-gray-600 rounded p-3 text-left flex flex-row md:flex-col items-center justify-between md:items-start transition active:bg-gray-600"
                                                onmouseenter="showTooltip(event, '<?= $loot['name'] ?>', '<?= $loot['desc'] ?>', 'UPGRADE')" onmouseleave="hideTooltip()">
                                                <div class="flex flex-col">
                                                    <span class="font-bold text-white text-sm md:text-lg"><?= $loot['name'] ?></span>
                                                    <span class="text-[10px] text-gray-400 lg:hidden"><?= $loot['desc'] ?></span>
                                                </div>
                                                <div class="text-xs text-green-500 font-bold">PEGAR</div>
                                            </button>
                                        </form>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php elseif ($game['phase'] === 'shop'): ?>
                            <div class="h-full flex flex-col">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-yellow-500 font-bold text-sm lg:text-lg">⛺ Loja</h3>
                                    <div class="flex gap-2">
                                        <form method="POST">
                                            <input type="hidden" name="action" value="refresh_shop">
                                            <button class="text-[10px] lg:text-xs bg-blue-900 border border-blue-600 px-3 py-2 rounded text-white disabled:opacity-50" <?= $game['player']['gold'] < 50 ? 'disabled' : '' ?>>🔄 50g</button>
                                        </form>
                                        <form method="POST"><input type="hidden" name="action" value="exit_shop"><button class="text-[10px] lg:text-xs bg-gray-600 px-3 py-2 rounded text-white">Sair ➔</button></form>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 flex-grow overflow-y-auto">
                                    <?php foreach ($game['shop_items'] as $idx => $item): ?>
                                        <form method="POST" class="h-full">
                                            <input type="hidden" name="action" value="buy_item">
                                            <input type="hidden" name="item_index" value="<?= $idx ?>">
                                            <button class="w-full h-full bg-gray-800 border border-gray-600 rounded p-3 flex justify-between items-center hover:border-yellow-500 disabled:opacity-40 transition active:bg-gray-700"
                                                <?= $game['player']['gold'] < $item['cost'] ? 'disabled' : '' ?>
                                                onmouseenter="showTooltip(event, '<?= $item['name'] ?>', '<?= $item['desc'] ?>', 'ITEM')" onmouseleave="hideTooltip()">
                                                <div class="text-left">
                                                    <div class="font-bold text-sm text-white"><?= $item['name'] ?></div>
                                                    <div class="text-[10px] text-gray-400 lg:hidden"><?= $item['desc'] ?></div>
                                                </div>
                                                <span class="text-yellow-400 font-mono font-bold text-sm bg-black/30 px-2 py-1 rounded"><?= $item['cost'] ?> G</span>
                                            </button>
                                        </form>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php elseif ($game['phase'] === 'game_over'): ?>
                            <div class="h-full flex flex-col items-center justify-center">
                                <h2 class="text-3xl font-bold text-red-600 mb-2">GAME OVER</h2>
                                <form method="POST"><input type="hidden" name="action" value="restart"><button class="bg-white text-black font-bold py-3 px-8 rounded shadow-lg active:scale-95">Tentar Novamente</button></form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>

            <aside class="hidden lg:flex glass-panel border-l border-gray-700 p-4 flex-col">
                <h3 class="text-gray-500 text-xs font-bold uppercase tracking-widest mb-4">Mochila</h3>
                <div class="flex-grow overflow-y-auto custom-scroll space-y-2 pr-1">
                    <?php if (empty($game['player']['inventory'])): ?>
                        <div class="text-center text-gray-700 italic text-sm mt-10">Vazio</div>
                    <?php endif; ?>
                    <?php foreach ($game['player']['inventory'] as $itemName => $qty):
                        $data = getItemDataByName($itemName); ?>
                        <div class="bg-gray-800 p-2 rounded border border-gray-600 text-sm font-bold text-gray-300 flex justify-between items-center cursor-help"
                            onmouseenter="showTooltip(event, '<?= $data['name'] ?>', '<?= $data['desc'] ?>', '<?= $data['type'] ?>')" onmouseleave="hideTooltip()">
                            <span><?= $itemName ?></span>
                            <?php if ($qty > 1): ?><span class="bg-gray-900 text-gray-400 text-xs px-2 py-1 rounded-full">x<?= $qty ?></span><?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </aside>

            <div id="mobile-inv" class="lg:hidden fixed inset-0 z-50 pointer-events-none">
                <div id="inv-backdrop" class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300" onclick="toggleInventory()"></div>
                <div id="inv-drawer" class="absolute bottom-0 left-0 w-full bg-slate-800 rounded-t-2xl shadow-2xl p-4 mobile-modal hidden-modal pointer-events-auto h-[60dvh] flex flex-col">
                    <div class="w-12 h-1 bg-gray-600 rounded-full mx-auto mb-4"></div>
                    <h3 class="text-white font-bold text-lg mb-4 flex justify-between">
                        <span>🎒 Inventário</span>
                        <span class="text-xs font-normal text-gray-400 mt-1">Clique fora para fechar</span>
                    </h3>

                    <div class="grid grid-cols-3 gap-2 mb-4 bg-black/20 p-2 rounded text-center text-xs text-gray-300">
                        <div>STR: <span class="text-white"><?= $game['player']['str'] ?></span></div>
                        <div>INT: <span class="text-white"><?= $game['player']['int'] ?></span></div>
                        <div>DEX: <span class="text-white"><?= $game['player']['dex'] ?></span></div>
                    </div>

                    <div class="overflow-y-auto flex-grow space-y-2 pb-4">
                        <?php if (empty($game['player']['inventory'])): ?>
                            <div class="text-center text-gray-500 italic mt-8">Sua mochila está vazia.</div>
                        <?php endif; ?>
                        <?php foreach ($game['player']['inventory'] as $itemName => $qty):
                            $data = getItemDataByName($itemName); ?>
                            <div class="bg-gray-700 p-3 rounded border border-gray-600 text-sm text-gray-200 flex justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="font-bold"><?= $itemName ?></span>
                                    <span class="text-[10px] text-gray-400"><?= $data['desc'] ?></span>
                                </div>
                                <?php if ($qty > 1): ?><span class="bg-black/40 px-3 py-1 rounded-full font-bold">x<?= $qty ?></span><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>

    <script>
        const logDiv = document.getElementById('gamelog');
        if (logDiv) logDiv.scrollTop = logDiv.scrollHeight;

        const tooltip = document.getElementById('tooltip');
        const ttTitle = document.getElementById('tt-title');
        const ttDesc = document.getElementById('tt-desc');
        const ttType = document.getElementById('tt-type');

        function showTooltip(e, name, desc, type) {
            if (window.innerWidth < 1024) return;
            ttTitle.innerText = name; ttDesc.innerText = desc; ttType.innerText = type;
            tooltip.style.display = 'block'; moveTooltip(e);
        }
        function hideTooltip() { tooltip.style.display = 'none'; }
        function moveTooltip(e) {
            if (tooltip.style.display === 'block') {
                let x = e.clientX + 15, y = e.clientY + 15;
                if (x + 210 > window.innerWidth) x = e.clientX - 215;
                if (y + 100 > window.innerHeight) y = e.clientY - 100;
                tooltip.style.left = x + 'px'; tooltip.style.top = y + 'px';
            }
        }
        document.addEventListener('mousemove', function (e) { if (e.target.closest('[onmouseenter]')) moveTooltip(e); });

        function toggleInventory() {
            const drawer = document.getElementById('inv-drawer');
            const backdrop = document.getElementById('inv-backdrop');
            const container = document.getElementById('mobile-inv');

            if (drawer.classList.contains('hidden-modal')) {
                container.classList.remove('pointer-events-none');
                drawer.classList.remove('hidden-modal');
                drawer.classList.add('show-modal');
                backdrop.style.opacity = '1';
                backdrop.style.pointerEvents = 'auto';
            } else {
                drawer.classList.remove('show-modal');
                drawer.classList.add('hidden-modal');
                backdrop.style.opacity = '0';
                backdrop.style.pointerEvents = 'none';
                setTimeout(() => {
                    container.classList.add('pointer-events-none');
                }, 300);
            }
        }
    </script>
</body>

</html>