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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
            <a href="javascript:void(0)" id="btn-home" data-page="home" class="nav-link">
                <span class="material-icons">home</span>
                <span class="menu-texto">Home</span>
            </a>
            <a href="javascript:void(0)" id="btn-storage" data-page="storage" class="nav-link">
                <span class="material-icons">storage</span>
                <span class="menu-texto">Storage</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" data-page="bag" class="nav-link">
                <span class="material-icons">backpack</span>
                <span class="menu-texto">Bag</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" data-page="map" class="nav-link">
                <span class="material-icons">map</span>
                <span class="menu-texto">Map</span>
            </a>
            <a href="javascript:void(0)" id="btn-bag" data-page="chat" class="nav-link">
                <span class="material-icons">chat</span>
                <span class="menu-texto">Chat</span>
            </a>
        </nav>
    </footer>

    <div id="modal-container" class="modal-overlay">
        <div class="modal-content">

        </div>
    </div>

    <script>
        // --- SCRIPT PRINCIPAL DA APLICAÇÃO ---
        document.addEventListener('DOMContentLoaded', function () {
            // --- ELEMENTOS GLOBAIS ---
            const mainContentContainer = document.querySelector('.conteudo-principal');
            const headerContainer = document.querySelector('.cabecalho-sobreposto');
            const navContainer = document.querySelector('.menu-sobreposto nav');
            const activeIndicator = document.querySelector('.active-indicator');

            // --- DELEGAÇÃO DE EVENTOS (A SOLUÇÃO) ---

            // Adiciona um único listener de eventos ao container principal.
            // Ele vai "ouvir" tudo o que acontece dentro dele.
            mainContentContainer.addEventListener('keyup', function (event) {
                // Se o elemento que disparou o evento tem o ID 'inventory-search-input'...
                console.log(event.target, event.target.id);
                if (event.target && event.target.id === 'inventory-search-input') {
                    // ...chama a função de filtro que está em bag.js
                    console.log('opa')
                    filterInventory();
                }
                else if (event.target && event.target.id === 'storage-search-input') {
                    // ...chama a função de filtro que está em bag.js
                    console.log('opa2')
                    filterStorage();
                }
            });

            // Delegação de eventos para o menu de navegação
            navContainer.addEventListener('click', (event) => {
                const clickedLink = event.target.closest('a.nav-link');
                if (!clickedLink) return;

                event.preventDefault();

                navContainer.querySelectorAll('.nav-link').forEach(item => item.classList.remove('active'));
                clickedLink.classList.add('active');
                moveIndicator(clickedLink);

                const pageName = clickedLink.dataset.page;
                if (pageName) {
                    navigateTo(pageName);
                }
            });

            // --- LÓGICA DO MENU ---
            function moveIndicator(target) {
                if (!target) return;
                const linkRect = target.getBoundingClientRect();
                const navRect = navContainer.getBoundingClientRect();
                const leftPosition = linkRect.left - navRect.left;
                activeIndicator.style.width = `${linkRect.width}px`;
                activeIndicator.style.left = `${leftPosition}px`;
            }

            // Observador para redimensionamento
            const resizeObserver = new ResizeObserver(() => {
                const currentActiveLink = document.querySelector('.menu-sobreposto .nav-link.active');
                moveIndicator(currentActiveLink);
            });
            resizeObserver.observe(navContainer);

            // --- CARREGAMENTO DE CONTEÚDO ---
            window.fetchContent = async function (fileName, targetSelector, params = {}, method = 'GET') {
                const targetElement = document.querySelector(targetSelector);
                if (!targetElement) throw new Error(`Alvo não encontrado: ${targetSelector}`);

                let url = `src/${fileName}.php`;
                let fetchOptions = { method };

                if (method.toUpperCase() === 'GET' && Object.keys(params).length) {
                    const queryString = new URLSearchParams(params).toString();
                    url += '?' + queryString;
                } else if (method.toUpperCase() === 'POST') {
                    fetchOptions.body = new URLSearchParams(params);
                    fetchOptions.headers = { 'Content-Type': 'application/x-www-form-urlencoded' };
                }

                const response = await fetch(url, fetchOptions);
                if (!response.ok) throw new Error(`Erro na rede: ${response.statusText}`);

                targetElement.innerHTML = await response.text();
            };


            async function navigateTo(pageName) {
                const promisesToLoad = [];
                switch (pageName) {
                    case 'home': case 'map': case 'chat':
                        promisesToLoad.push(fetchContent('includes/header_hud', '.cabecalho-sobreposto'));
                        break;
                    case 'storage':
                        promisesToLoad.push(fetchContent('includes/header_storage', '.cabecalho-sobreposto'));
                        break;
                    case 'bag':
                        promisesToLoad.push(fetchContent('includes/header_bag', '.cabecalho-sobreposto'));
                        break;
                    default:
                        headerContainer.innerHTML = '';
                        break;
                }
                promisesToLoad.push(fetchContent('pages/' + pageName, '.conteudo-principal'));
                try {
                    await Promise.all(promisesToLoad);
                    window.scrollTo({ top: 0, behavior: 'auto' });
                } catch (error) {
                    console.error("Falha no carregamento:", error);
                }
            }

            // --- INICIALIZAÇÃO ---
            const homeButton = document.getElementById('btn-home');
            if (homeButton) {
                homeButton.click();
            }
        });

    </script>
    <script src="assets/js/digimon.js"></script>
    <script src="assets/js/modal.js"></script>
    <script src="assets/js/bag.js"></script>

</body>

</html>