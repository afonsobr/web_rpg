<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'src/bootstrap.php';

$_SESSION['account_uuid'] = 1;


?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="style.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="utilities.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- FontAwesome -->
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/fontawesome.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/solid.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/brands.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/regular.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/light.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/thin.css">
    <link defer media="all" onload="this.media='all'" rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v7.0.1/css/duotone.css">
</head>

<body>
    <header class="cabecalho-sobreposto">
        <?php
        include('src/includes/header_hud.php');
        ?>
    </header>

    <main class="conteudo-principal">
        <?php
        include('src/pages/home.php');
        ?>
    </main>
    <footer class="menu-sobreposto">
        <nav>
            <div class="active-indicator"></div>
            <a href="javascript:void(0)" id="btn-home" onclick="navigateTo('home')" class="nav-link">
                <span class="material-icons">home</span>
                <span class="menu-texto">Home</span>
            </a>
            <a href="#" class="nav-link">
                <span class="material-icons">storage</span>
                <span class="menu-texto">Storage</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" onclick="navigateTo('bag')" class="nav-link">
                <span class="material-icons">backpack</span>
                <span class="menu-texto">Bag</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" onclick="navigateTo('map')" class="nav-link">
                <span class="material-icons">map</span>
                <span class="menu-texto">Map</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" onclick="navigateTo('chat')" class="nav-link">
                <span class="material-icons">chat</span>
                <span class="menu-texto">Chat</span>
            </a>
        </nav>
    </footer>

    <script>
        // --- Seleção dos Elementos ---
        const menu = document.querySelector('.menu-sobreposto');
        const navContainer = document.querySelector('.menu-sobreposto nav');
        const navLinks = document.querySelectorAll('.menu-sobreposto .nav-link');
        const activeIndicator = document.querySelector('.active-indicator');

        // Função única para mover o indicador
        function moveIndicator(target) {
            if (!target) return;
            const linkRect = target.getBoundingClientRect();
            const navRect = navContainer.getBoundingClientRect();
            const leftPosition = linkRect.left - navRect.left;

            activeIndicator.style.width = `${linkRect.width}px`;
            activeIndicator.style.left = `${leftPosition}px`;
        }

        // Lida com o clique nos links
        navLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();

                // Remove 'active' de todos antes de adicionar no clicado
                navLinks.forEach(item => item.classList.remove('active'));
                const clickedLink = event.currentTarget;
                clickedLink.classList.add('active');

                // Move o indicador para o novo alvo
                moveIndicator(clickedLink);
            });
        });


        // --- FUNCIONALIDADE 3 (NOVO!): ATUALIZAÇÃO EM RESIZE ---

        // Cria um observador que fica de olho em mudanças de tamanho na 'nav'
        const resizeObserver = new ResizeObserver(() => {
            // Quando a 'nav' mudar de tamanho, encontre o link que está ativo...
            const currentActiveLink = document.querySelector('.menu-sobreposto .nav-link.active');
            // ... e recalcule a posição do indicador para ele.
            moveIndicator(currentActiveLink);
        });

        // Inicia a observação no container da navegação
        resizeObserver.observe(navContainer);

        // FIM

        // No seu arquivo .js ou na tag <script>
        // const settingsLink = document.getElementById('link-settings');

        // settingsLink.addEventListener('click', (event) => {
        //     event.preventDefault(); // Impede o comportamento padrão do link
        //     loadPage('setting');
        // });

        // Coloque esta função no seu script principal,
        // pode ser junto com os outros scripts que já criamos.
        /**
         * Orquestra a navegação da página de forma otimizada (carregamento em paralelo).
         * @param {string} pageName - O nome da página para a qual navegar.
         */
        async function navigateTo(pageName) {
            // 1. Criamos um array para guardar todas as "promessas" de carregamento.
            const promisesToLoad = [];
            const headerContainer = document.querySelector('.cabecalho-sobreposto');

            // 2. Lógica do Header: em vez de 'await', nós "empurramos" a promessa para o array.
            // A tarefa começa a ser executada em segundo plano imediatamente.
            switch (pageName) {
                case 'home':
                case 'map':
                case 'chat':
                case 'profile':
                    promisesToLoad.push(fetchContent('includes/header_hud', '.cabecalho-sobreposto'));
                    break;
                case 'bag':
                    promisesToLoad.push(fetchContent('includes/header-bag', '.cabecalho-sobreposto'));
                    break;
                case 'news':
                    headerContainer.innerHTML = '';
                    break;
                default:
                    headerContainer.innerHTML = '<div></div>';
                    break;
            }

            // 3. Também "empurramos" a promessa de carregar o conteúdo principal para o array.
            // Agora as duas requisições (header e content) estão rodando AO MESMO TEMPO.
            promisesToLoad.push(fetchContent('pages/' + pageName, '.conteudo-principal'));

            try {
                // 4. Promise.all() espera que TODAS as promessas no array sejam resolvidas.
                // O código só continua depois que AMBOS os conteúdos (header e main) tiverem chegado.
                await Promise.all(promisesToLoad);

                // 5. Agora que tudo está garantidamente na tela, resetamos o scroll.
                window.scrollTo({
                    top: 0,
                    behavior: 'auto'
                });

            } catch (error) {
                // Se QUALQUER uma das promessas falhar, o Promise.all é rejeitado
                // e o erro é capturado aqui, o que é ótimo para o tratamento de erros.
                console.error("Uma ou mais tarefas de carregamento falharam:", error);
            }
        }


        /**
         * Função auxiliar que busca o conteúdo
         * @param {string} fileName - O nome do arquivo a ser buscado.
         * @param {string} targetSelector - O seletor CSS do elemento alvo.
         */
        async function fetchContent(fileName, targetSelector) {
            const targetElement = document.querySelector(targetSelector);
            if (!targetElement) {
                // Lança um erro para ser capturado pelo Promise.all
                throw new Error(`Elemento alvo não encontrado: ${targetSelector}`);
            }
            const url = `src/${fileName}.php`;

            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Erro na rede ao buscar ${url}: ${response.statusText}`);
            }

            // O await aqui dentro é normal, ele só atualiza o HTML DEPOIS que o fetch termina.
            targetElement.innerHTML = await response.text();
        }

        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                // 1. Encontra o elemento (link ou botão) pelo seu ID único.
                const homeButton = document.getElementById('btn-home');

                // 2. Uma verificação de segurança: só tenta clicar se o elemento realmente existir.
                if (homeButton) {
                    // 3. Simula um clique no elemento.
                    homeButton.click();
                }
            }, 200);
        });
    </script>
</body>

</html>