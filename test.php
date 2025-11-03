<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Eterion Online - Layout de 3 Colunas</title>
    <meta name="description" content="Um jogo de RPG de navegador estilo fantasia.">
    <meta name="author" content="Lorde das Trevas">

    <meta property="og:title" content="Eterion Online">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Um jogo de RPG de navegador estilo fantasia.">
    <meta property="og:image" content="image.png">
    <link rel="icon" href="/favicon.ico">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <style>
        /* =============================================
         * PALETA DE CORES E RESET
         * =============================================
        */
        :root {
            --color-bg-panel: rgba(244, 240, 232, 0.7);
            --color-border-ornate: rgba(166, 144, 122, 0.7);
            --color-text-dark: #3a3a3a;
            --color-text-light: #5b5b5b;
            --color-primary: #5b8ec8;
            --color-primary-hover: #4a7bb5;
            --color-online: #4CAF50;
            /* Verde para status "Online" */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: var(--color-text-dark);
            line-height: 1.6;
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

        /* =============================================
         * LAYOUT GLOBAL (HEADER, LOGO, WRAPPER)
         * =============================================
        */

        .body-header {
            font-family: sans-serif;
            font-style: italic;
            background: linear-gradient(0deg, #7a8aa4ca 0%, #4079abca 100%);
            width: 100%;
            padding: 5px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            font-size: 18px;
            color: white;
            text-shadow: 1px 1px 2px #66ccccca;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-bottom: 2px solid #4f6badca;
            position: sticky;
            /* Fixa o header no topo */
            top: 0;
            z-index: 100;
            /* Garante que fique acima de outros elementos */
        }

        /* Wrapper para garantir padding mínimo em telas pequenas */
        .main-content-wrapper {
            padding-left: 10px;
            padding-right: 10px;
        }

        .logo {
            text-align: center;
            margin-top: 20px;
        }

        .logo>img {
            max-width: 250px;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
        }

        /* --- O Container "Vidro Fosco" Principal --- */
        .game-container {
            background-color: rgba(255, 255, 255, 0.30);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);

            /* =============================================
             * ALTERAÇÃO PRINCIPAL DO GRID AQUI
             * =============================================
            */
            display: grid;
            /* Definimos 3 colunas: nav-left, main, nav-right */
            grid-template-areas:
                "header   header     header"
                "nav-left main       nav-right"
                "footer   footer     footer";

            /* Largura das colunas: 200px, 1fr (flexível), 200px */
            grid-template-columns: 200px 1fr 200px;
            grid-template-rows: auto 1fr auto;
            grid-gap: 15px;

            max-width: 1200px;
            /* Aumentado para acomodar as 3 colunas */
            margin: 20px auto 40px auto;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            padding: 15px;
        }

        /* =============================================
         * COMPONENTES INTERNOS DO JOGO
         * =============================================
        */

        /* --- 1. Header do Jogo (Infos do Jogador) --- */
        .game-header {
            grid-area: header;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-border-ornate);
        }

        /* (Estilos de .player-info e .player-resources mantidos como antes) */
        .player-info {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .player-mugshot img {
            width: 50px;
            border-radius: 999px;
        }

        .player-info .player-name {
            font-size: 1.3em;
            font-weight: bold;
        }

        .player-info .player-level {
            font-size: 1em;
            color: var(--color-primary-hover);
            margin-left: 10px;
        }

        .player-resources span {
            font-weight: bold;
            padding: 5px 12px;
            background-color: var(--color-bg-panel);
            border: 1px solid var(--color-border-ornate);
            border-radius: 6px;
            font-size: 0.95em;
            margin-left: 10px;
        }


        /* --- 2. Navegação (Menu da Esquerda) --- */
        /* RENOMEADO de .game-nav para .game-nav-left */
        .game-nav-left {
            grid-area: nav-left;
            /* Nome da área no grid */
        }

        .game-nav-left h3 {
            font-size: 1.1em;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--color-border-ornate);
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .game-nav-left ul {
            list-style: none;
        }

        .game-nav-left li {
            margin-bottom: 6px;
        }

        .game-nav-left a {
            display: block;
            padding: 10px 12px;
            text-decoration: none;
            color: var(--color-text-dark);
            font-weight: bold;
            font-size: 0.95em;
            border-radius: 6px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .game-nav-left a:hover {
            background-color: rgba(255, 255, 255, 0.4);
            border-color: var(--color-border-ornate);
        }

        .game-nav-left a.active {
            background-color: var(--color-primary);
            color: #fff;
            border-color: var(--color-primary-hover);
        }

        /* --- 3. Conteúdo Principal (Janela Interna) --- */
        .game-main {
            grid-area: main;
            overflow-y: auto;
        }

        /* (Estilos de .content-window, .window-header, .window-body mantidos como antes) */
        .content-window {
            background-color: rgba(255, 255, 255, 0.5);
            border: 1px solid var(--color-border-ornate);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .window-header {
            background-color: var(--color-bg-panel);
            border-bottom: 1px solid var(--color-border-ornate);
            padding: 10px 15px;
        }

        .window-header h2 {
            margin: 0;
        }

        .window-body {
            padding: 15px;
        }

        .window-body p {
            margin-bottom: 15px;
        }


        /* --- 4. NOVO: Barra Lateral Direita (Aside) --- */
        .game-sidebar-right {
            grid-area: nav-right;
            /* Nome da área no grid */
            overflow-y: auto;
            /* Permite scroll se tiver muito conteúdo */
        }

        /* Estilo de "Widget" para a barra lateral */
        .widget {
            background-color: var(--color-bg-panel);
            border: 1px solid var(--color-border-ornate);
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* Para o header do widget */
        }

        .widget-header {
            padding: 10px 15px;
            border-bottom: 1px solid var(--color-border-ornate);
            background-color: rgba(255, 255, 255, 0.2);
        }

        .widget-header h3 {
            margin: 0;
            font-size: 1.1em;
            color: var(--color-text-dark);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .widget-body {
            padding: 15px;
            font-size: 0.9em;
        }

        .widget-body ul {
            list-style: none;
        }

        .widget-body li {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--color-border-ornate);
            display: flex;
            align-items: center;
        }

        .widget-body li:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        /* Ponto de status Online/Offline */
        .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            flex-shrink: 0;
            /* Impede que o ponto encolha */
        }

        .status-online {
            background-color: var(--color-online);
        }

        .status-offline {
            background-color: #aaa;
        }


        /* --- 5. Rodapé do Jogo (Notificações) --- */
        .game-footer {
            grid-area: footer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 10px;
            border-top: 2px solid var(--color-border-ornate);
            font-size: 0.9em;
            color: var(--color-text-light);
        }

        /* (Estilos de .footer-notification mantidos como antes) */
        .footer-notification {
            background-color: #f2db99;
            color: var(--color-text-dark);
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }


        /* =============================================
         * ELEMENTOS DE UI (BOTÕES, ABAS, BARRAS)
         * =============================================
        */
        /* (Todos os estilos de .action-buttons, .action-log, .tab-navigation, .progress-bar foram mantidos como antes) */

        /* --- Botões de Ação --- */
        .action-buttons {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            background-color: var(--color-primary);
            color: #fff;
            border: none;
            padding: 10px 18px;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 1em;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            border-bottom: 3px solid var(--color-primary-hover);
        }

        .action-buttons button:hover {
            background-color: var(--color-primary-hover);
        }

        /* --- Log de Ações --- */
        .action-log {
            background-color: rgba(255, 255, 255, 0.6);
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 15px;
            height: 200px;
            overflow-y: scroll;
            margin-top: 20px;
        }

        .action-log h3 {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .action-log ul {
            list-style: none;
        }

        .action-log li {
            font-size: 0.9em;
            color: var(--color-text-light);
            margin-bottom: 8px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 4px;
        }

        /* --- Abas (Tabs) --- */
        .tab-navigation {
            display: flex;
            border-bottom: 2px solid var(--color-border-ornate);
            margin-bottom: 15px;
        }

        .tab-navigation button {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-family: Georgia, 'Times New Roman', Times, serif;
            font-weight: bold;
            font-size: 1em;
            color: var(--color-text-light);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }

        .tab-navigation button:hover {
            color: var(--color-text-dark);
        }

        .tab-navigation button.active {
            color: var(--color-primary-hover);
            border-bottom-color: var(--color-primary-hover);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* --- Barras de Progresso --- */
        .progress-bar-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .progress-bar-container {
            width: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .progress-bar-fill {
            height: 22px;
            background-color: var(--color-primary);
            background: linear-gradient(to right, var(--color-primary), var(--color-primary-hover));
            border-radius: 4px;
            transition: width 0.5s ease-out;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .progress-bar-text {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            color: #fff;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.5);
            font-weight: bold;
            font-size: 0.9em;
            line-height: 22px;
        }


        /* =============================================
         * RESPONSIVIDADE (MOBILE)
         * =============================================
        */
        @media (max-width: 900px) {
            .game-container {
                /* Em telas menores, muda para 1 coluna */
                grid-template-areas:
                    "header"
                    "nav-left"
                    "main"
                    "nav-right"
                    /* A barra da direita vai para baixo do 'main' */
                    "footer";
                grid-template-columns: 1fr;
                /* Coluna única */
                max-width: 100%;
                /* Ocupa a largura total */
                margin-top: 10px;
                grid-gap: 10px;
            }

            /* Faz o menu da esquerda rolar horizontalmente */
            .game-nav-left ul {
                display: flex;
                overflow-x: auto;
                padding-bottom: 10px;
            }

            .game-nav-left li {
                margin-bottom: 0;
                margin-right: 8px;
                flex-shrink: 0;
            }

            /* Faz a barra da direita se parecer com o 'main' */
            .game-sidebar-right {
                padding: 0;
            }
        }

        .html {
            overflow: auto;
            overscroll-behavior: contain;
            /* or none */
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <header class="body-header">
        <div>Login</div>
        <div>Server Time: 13:16:04</div>
    </header>

    <div class="main-content-wrapper">

        <div class="logo">
            <img src="https://i.imgur.com/qaqnOKj.png" alt="Logo Eterion">
        </div>

        <section class="game-container">

            <header class="game-header">

                <div class="player-info">
                    <div class="player-mugshot">
                        <img src="https://i.imgur.com/CXWlQXl.png" alt="">
                    </div>
                    <div class="player-name">Lorde das Trevas</div>
                    <div class="player-level">Nível 87</div>
                </div>
                <div class="player-resources">
                    <span class="currency-zeny">💎 1.234.567 Zeny</span>
                    <span class="currency-cash">💰 500 ROPs</span>
                </div>
            </header>

            <nav class="game-nav-left">
                <div class="card">
                    <form action="">
                        <div>
                            <input type="text">
                            <input type="text">
                        </div>
                        <button>Enter</button>
                        <div>
                            <p> or Register.</p>
                            <p>Forgot my password!</p>
                        </div>
                    </form>
                </div>
                <h3>Navegação</h3>
                <ul>
                    <li><a href="#" class="active">Cidade</a></li>
                    <li><a href="#">Missões</a></li>
                    <li><a href="#">Inventário</a></li>
                    <li><a href="#">Mapa (Regiões)</a></li>
                    <li><a href="#">PvP (Arena)</a></li>
                    <li><a href="#">Loja de ROPs</a></li>
                    <li><a href="#">Clã</a></li>
                    <li><a href="#">Configurações</a></li>
                </ul>
            </nav>

            <main class="game-main">
                <article class="content-window">
                    <header class="window-header">
                        <h2>Sua Cidade: Prontera</h2>
                    </header>
                    <div class="window-body">

                        <nav class="tab-navigation">
                            <button class="active">Visão Geral</button>
                            <button>Construção</button>
                            <button>Recursos</button>
                        </nav>

                        <div class="tab-content active">
                            <p>Bem-vindo à sua cidade principal. A partir daqui, você pode gerenciar seus edifícios, treinar unidades e coletar recursos.</p>

                            <div class="progress-bar" style="margin-bottom: 20px;">
                                <span class="progress-bar-label">Mina de Ouro (Nível 5 → 6)</span>
                                <div class="progress-bar-container">
                                    <div class="progress-bar-fill" style="width: 65%;"></div>
                                    <span class="progress-bar-text">65% (01:15:30 restante)</span>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <button>Coletar Recursos</button>
                                <button>Treinar Ferreiro</button>
                            </div>

                            <div class="action-log">
                                <h3>Log de Eventos</h3>
                                <ul>
                                    <li>[10:25:12] Seu 'Ferreiro' completou a 'Espada Longa'.</li>
                                    <li>[10:22:01] Você coletou 1.500 Aço e 800 Carvão.</li>
                                    <li>[10:18:45] Um 'Noviço' foi treinado com sucesso.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <p>Gerencie suas construções e melhorias.</p>
                        </div>

                        <div class="tab-content">
                            <p>Aqui você verá seus recursos e produção por hora.</p>
                        </div>
                    </div>
                </article>
            </main>

            <aside class="game-sidebar-right">

                <div class="widget">
                    <header class="widget-header">
                        <h3>Amigos Online (3)</h3>
                    </header>
                    <div class="widget-body">
                        <ul>
                            <li>
                                <span class="status-dot status-online"></span>
                                <span>PoringSlayer</span>
                            </li>
                            <li>
                                <span class="status-dot status-online"></span>
                                <span>KafraGirl</span>
                            </li>
                            <li>
                                <span class="status-dot status-online"></span>
                                <span>Deviruchi</span>
                            </li>
                            <li>
                                <span class="status-dot status-offline"></span>
                                <span>BaphometJr</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="widget">
                    <header class="widget-header">
                        <h3>Eventos Ativos</h3>
                    </header>
                    <div class="widget-body">
                        <p>🔥 Bônus de EXP em Dobro!</p>
                        <p>🕒 (Termina em 02:45:10)</p>
                    </div>
                </div>

            </aside>

            <footer class="game-footer">
                <div class="footer-notification">
                    🔔 Construção 'Mina de Ouro' Nv. 5 concluída!
                </div>
                <div class="server-status">
                    Servidor: Loki | Status: Online | © 2025 Eterion
                </div>
            </footer>

        </section>

    </div>
</body>

</html>