<?php
// Marca o tempo inicial
$start_time = microtime(true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/utilities.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Elms+Sans:ital,wght@0,100..900;1,100..900&family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap');


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            /* font-family: Georgia, 'Times New Roman', Times, serif; */
            font-family: "Titillium Web", sans-serif;
            color: var(--color-text-dark);
            line-height: 1.6;
        }

        html {
            background-color: #ffffff;
            background-image:
                linear-gradient(to bottom,
                    rgba(83, 208, 233, 0) 60%,
                    rgba(69, 166, 193, 0.5) 85%,
                    rgba(255, 255, 255, 1) 100%),
                url('https://wallpaper.forfun.com/fetch/f2/f2f2e0e4cec196eeef10a566e0e03434.jpeg');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        .body-header {
            backdrop-filter: blur(10px);
            background-color: #00000073;
            width: 100%;
            padding: 6px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            font-size: 14px;
            color: #d8d8d8ff;
            border-bottom: 1px solid #cecece3f;
            position: sticky;
            /* Fixa o header no topo */
            top: 0;
            z-index: 100;
            /* Garante que fique acima de outros elementos */
        }

        .game-footer {
            /* backdrop-filter: blur(10px); */
            /* background-color: #00000073; */
            margin-top: 20px;
            width: 100%;
            padding: 6px 0;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0px;
            font-size: 14px;
            color: #191919ff;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .logo {
            margin-top: 10px;
            width: 100%;
            text-align: center;
            /* padding: 10px 0; */
        }

        .logo img {
            height: 100px;
        }

        .game-container,
        .game-header {
            border-radius: 8px;
            background-color: #ffffff58;
            max-width: 1000px;
            margin-left: 10px;
            margin-right: 10px;
            margin: auto;
            backdrop-filter: blur(10px);
            padding: 12px;
        }

        .game-header {
            margin-bottom: 12px;
        }

        /* ia */
        .game-header {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(6px);
            border-radius: 12px;
            padding: 10px 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .player-info {
            flex: 1;
            text-align: left;
        }

        .player-status {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .player-resources {
            flex: 1;
            text-align: center;
        }

        .status-bar {
            position: relative;
            height: 14px;
            border-radius: 8px;
            overflow: hidden;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .status-bar .fill {
            height: 100%;
            transition: width 0.3s ease;
        }

        .hp-bar .fill {
            background: linear-gradient(90deg, #d9534f, #ff7675);
        }

        .mana-bar .fill {
            background: linear-gradient(90deg, #3498db, #5dade2);
        }

        .exp-bar .fill {
            background: linear-gradient(90deg, #f1c40f, #f9e79f);
        }

        .status-bar .label {
            position: absolute;
            top: -3px;
            left: 5px;
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        /* 2 */
        .game-overview h2 {
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .game-overview p {
            font-size: 15px;
            color: #333;
            margin-bottom: 12px;
        }

        .encounter {
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
            backdrop-filter: blur(5px);
        }

        .enemy {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .actions .btn {
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            font-weight: bold;
            background: linear-gradient(90deg, #6ec1e4, #3498db);
            color: white;
            transition: all 0.2s ease;
        }

        .actions .btn:hover {
            transform: scale(1.05);
            background: linear-gradient(90deg, #3498db, #6ec1e4);
        }

        .log {
            background: rgba(255, 255, 255, 0.35);
            border-radius: 10px;
            padding: 10px;
            backdrop-filter: blur(5px);
        }

        .log h3 {
            margin-bottom: 6px;
            color: #2c3e50;
        }

        .log-box {
            max-height: 150px;
            overflow-y: auto;
            font-size: 14px;
            color: #222;
            line-height: 1.4;
        }

        .log-box .dmg {
            color: #c0392b;
            font-weight: bold;
        }

        /* layout */
        .layout {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 12px;
            max-width: 1110px;
            margin: 0 auto;
        }

        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(8px);
            border-radius: 10px;
            padding: 10px 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: #2c3e50;
            font-size: 15px;
        }

        .sidebar h3 {
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
            color: #1b3a4b;
        }

        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }

        .sidebar li {
            margin-bottom: 6px;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .sidebar li:hover {
            color: #3498db;
        }

        .main-content {
            flex: 1;
            max-width: 900px;
        }

        @media (max-width: 1100px) {
            .layout {
                flex-direction: column;
                align-items: center;
            }

            .sidebar {
                width: 90%;
                order: 2;
            }

            .right {
                order: 3;
            }

            .main-content {
                order: 1;
            }
        }

        hr {
            border: 0px;
            opacity: 0.5;
            border-top: 1px solid #555;
            margin: 0px;
            margin-bottom: 1em;
            margin-top: 1em;
        }
    </style>
</head>

<body>
    <header class="body-header">
        <a href="">Login</a>
        <a href="">Register</a>
        <a href="">Terms of Use</a>
        <a>Server Time: <span id="server-clock"></span> </a>
    </header>
    <div class="logo">
        <img src="https://i.imgur.com/qaqnOKj.png" alt="Logo Eterion">
    </div>
    <div class="page-content layout">
        <!-- Sidebar Esquerda -->
        <aside class="sidebar left">
            <h3>📜 Menu</h3>
            <ul>
                <li><a href="#">Personagem</a></li>
                <li><a href="#">Inventário</a></li>
                <li><a href="#">Missões</a></li>
                <li><a href="#">Mapa</a></li>
                <li><a href="#">Guilda</a></li>
            </ul>
        </aside>



        <!-- Conteúdo Central -->
        <main class="main-content">
            <header class="game-header d-flex items-center justify-between">
                <div class="player-info d-flex items-center justify-between flex-col">
                    <div class="player-name">Lorde das Trevas</div>
                    <div class="player-level opacity-50">Lv 87</div>
                </div>

                <div class="player-status flex-col w-100 pl-3 pr-3">
                    <div class="status-bar hp-bar">
                        <div class="fill" style="width: 12%;"></div>
                        <span class="label">HP: 780/1000</span>
                    </div>
                    <div class="status-bar mana-bar">
                        <div class="fill" style="width: 60%;"></div>
                        <span class="label">MP: 300/500</span>
                    </div>
                    <div class="status-bar exp-bar">
                        <div class="fill" style="width: 45%;"></div>
                        <span class="label">EXP: 45%</span>
                    </div>
                </div>

                <div class="player-resources items-center justify-between flex-col">
                    <div class="currency-zeny">💎 1.234.567 Zeny</div>
                    <div class="currency-cash">💰 500 ROPs</div>
                </div>
            </header>

            <div class="game-container">
                <section class="game-overview">
                    <h2>Character</h2>
                    <div class="">
                        <!-- Coluna 1: Status -->
                        <div class="d-flex flex-col">
                            <p class="font-bold">Status</p>
                            <!-- Cada atributo -->
                            <div class="d-flex justify-between items-center">
                                <span>STR</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2">15</span>
                                    <button class="rounded-full text-primary px-2 text-sm font-bold cursor-pointer border-0">+</button>
                                </div>
                            </div>

                            <div class="d-flex justify-between items-center">
                                <span>AGI</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2">12</span>
                                    <button class="rounded-full text-primary px-2 text-sm font-bold cursor-pointer border-0">+</button>
                                </div>
                            </div>

                            <div class="d-flex justify-between items-center">
                                <span>CON</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2">10</span>
                                    <button class="rounded-full text-primary px-2 text-sm font-bold cursor-pointer border-0">+</button>
                                </div>
                            </div>

                            <div class="d-flex justify-between items-center">
                                <span>INT</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2">18</span>
                                    <button class="rounded-full text-primary px-2 text-sm font-bold cursor-pointer border-0">+</button>
                                </div>
                            </div>

                            <div class="d-flex justify-between items-center">
                                <span>DEX</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2">14</span>
                                    <button class="rounded-full text-primary px-2 text-sm font-bold cursor-pointer border-0">+</button>
                                </div>
                            </div>

                            <div class="d-flex justify-between items-center">
                                <span>Remaining Points</span>
                                <div class="d-flex items-center">
                                    <span class="pr-2 font-bold text-primary">12</span>
                                </div>
                            </div>
                        </div>
                        <!-- Separador -->
                        <hr>
                        <!-- Coluna 2: Atributos -->
                        <div class="d-flex flex-col">
                            <p class="font-bold">Attributes</p>

                            <div class="d-flex justify-between"><span>ATK</span><span>123</span></div>
                            <div class="d-flex justify-between"><span>DEF</span><span>231</span></div>
                            <div class="d-flex justify-between"><span>MATK</span><span>412</span></div>
                            <div class="d-flex justify-between"><span>MDEF</span><span>312</span></div>
                            <div class="d-flex justify-between"><span>CRIT DMG</span><span>+25%</span></div>
                            <div class="d-flex justify-between"><span>CRIT RATE</span><span>12%</span></div>
                            <div class="d-flex justify-between"><span>Max HP</span><span>1023</span></div>
                            <div class="d-flex justify-between"><span>Max MP</span><span>1233</span></div>

                        </div>
                    </div>

                    <!-- Separador -->
                    <hr>
                    <!-- Equipamentos -->
                    <div class="d-flex flex-col">
                        <p class="font-bold">Equipment</p>
                        <div class="d-flex justify-between"><span>Hat</span><span>-</span></div>
                        <div class="d-flex justify-between"><span>Weapon</span><span>-</span></div>
                        <div class="d-flex justify-between"><span>Shield</span><span>-</span></div>
                        <div class="d-flex justify-between"><span>Armor</span><span>Elmo de Ferro</span></div>
                        <div class="d-flex justify-between"><span>Boots</span><span>Elmo de Ferro</span></div>
                        <div class="d-flex justify-between"><span>Manteau</span><span>Elmo de Ferro</span></div>
                        <div class="d-flex justify-between"><span>Ring</span><span>Elmo de Ferro</span></div>
                        <div class="d-flex justify-between"><span>Ring</span><span>Elmo de Ferro</span></div>
                        <div class="d-flex justify-between"><span>Badge</span><span>Elmo de Ferro <img src="https://www.divine-pride.net/img/items/item/bRO/2007" alt=""> </span></div>
                        <div class="d-flex justify-between"><span>Accessory</span><span>Elmo de Ferro</span></div>
                    </div>
                </section>

                <section class="game-overview">
                    <h2>🌍 Campo de Caça: Floresta Nebulosa</h2>
                    <p>
                        A névoa cobre o chão enquanto criaturas misteriosas rondam entre as árvores.
                        Você sente uma presença observando — talvez um espírito antigo da floresta.
                    </p>

                    <div class="encounter">
                        <div class="enemy">
                            <strong>Inimigo:</strong> Lobo Sombrio<br>
                            <span>Nível 85 • HP: 950/950</span>
                        </div>
                        <div class="actions">
                            <button class="btn attack">⚔️ Atacar</button>
                            <button class="btn skill">✨ Habilidade</button>
                            <button class="btn item">🎒 Item</button>
                            <button class="btn flee">🏃 Fugir</button>
                        </div>
                    </div>
                </section>

                <section class="log">
                    <h3>📜 Registro de Batalha</h3>
                    <div class="log-box">
                        <p><strong>Você</strong> atacou o <em>Lobo Sombrio</em> — causou <span class="dmg">156</span> de dano!</p>
                        <p><em>Lobo Sombrio</em> arranhou — você recebeu <span class="dmg">72</span> de dano.</p>
                    </div>
                </section>
            </div>
        </main>

        <!-- Sidebar Direita -->
        <aside class="sidebar right">
            <h3>🎒 Inventário</h3>
            <ul>
                <li>Poção de Cura ×5</li>
                <li>Éter Mágico ×2</li>
                <li>Espada Longa +3</li>
                <li>Elmo de Ferro</li>
            </ul>
        </aside>
    </div>

    <aside class="game-footer">
        Eterion. 2025.<br>
        <small>
            <?php

            // Marca o tempo final
            $end_time = microtime(true);

            // Calcula o tempo total em segundos
            $execution_time = $end_time - $start_time;

            // Exibe o resultado formatado
            echo "Generated in " . number_format($execution_time, 4) . " seconds";
            ?>
        </small>
    </aside>
</body>

</html>

<?php
$serverTime = time() * 1000; // tempo atual do servidor em milissegundos
?>
<script>
    let serverTime = <?php echo $serverTime; ?>;
    // A variável serverTime vem do PHP
    function updateServerClock() {
        let date = new Date(serverTime);
        let hours = String(date.getHours()).padStart(2, '0');
        let minutes = String(date.getMinutes()).padStart(2, '0');
        let seconds = String(date.getSeconds()).padStart(2, '0');
        document.getElementById('server-clock').textContent = `${hours}:${minutes}:${seconds}`;
        serverTime += 1000; // avança 1 segundo
    }

    updateServerClock(); // mostra imediatamente
    setInterval(updateServerClock, 1000); // atualiza a cada 1s
</script>