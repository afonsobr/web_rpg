// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('loaded battle-prepare.js');

    const battleWindow = document.getElementById('battle-window');


    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    const searchLoading = `
    <div class="pb-4">
        <div class="rounded bg-surface">
            <div class="d-flex w-100 p-3">
                <div class="d-flex w-100 justify-center items-center" style="min-height: 28px">
                    <div class="font-normal nowrap pr-3" >Analyzing & Searching...</div>
                </div>
            </div>
        </div>
    </div>
    `;


    window.searchForEnemies = async function () {
        const searchEnemieBtn = document.getElementById('search-enemies-btn');
        const enemiesTable = document.getElementById('enemies-table');

        if (!searchEnemieBtn) return;
        if (!enemiesTable) return;

        try {
            searchEnemieBtn.classList.add('disabled');
            enemiesTable.classList.add('disabled');
            enemiesTable.innerHTML = searchLoading;
            // Espera 3 segundos antes de buscar os inimigos
            setTimeout(async () => {
                if (!enemiesTable) return;
                await fetchFunc('api/api_search_enemies', '#enemies-table');
                searchEnemieBtn.classList.remove('disabled');
                enemiesTable.classList.remove('disabled');
            }, 800); //1500
        } catch (error) {
            console.error("Erro ao abrir a janela do Digimon:", error);
        }
    };

    const confirmModal = document.getElementById('confirm-modal');

    window.showBattleConfirmation = function () {
        showConfirmationModal('Start battle now?',
            preloadWindowBattle,
            () => {
            });
    }

    window.showAbandonBattleConfirmation = function () {
        showConfirmationModal('Run Away from Battle now?',
            abandonBattle,
            () => {
            });
    }

    window.abandonBattleWithoutConfirmation = async function () {
        await fetchFunc('includes/header_hud', '.cabecalho-sobreposto');
        abandonBattle();
    }

    async function preloadWindowBattle() {
        console.log('window.preloadWindowBattle');

        // Carrega o conteudo
        await fetchFunc('pages/battle', '#battle-window-content');

        const battleStatus = await apiRequest('api/api_account', { action: 'changeBattleStatus', battleStatus: true });
        console.log(battleStatus);

        // Mostra a janela e limpa os inimigos
        battleWindow.classList.add('active');
        clearEnemiesTable();
        const modalContent = battleWindow.querySelector('.modal-content');
        if (modalContent) {
            modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            enableCommands();
        }
    }

    async function abandonBattle() {
        battleWindow.classList.remove('active');
        console.log('window.preloadWindowBattle');
        // await fetchFunc('pages/battle', '#battle-window-content');
        const modalContent = battleWindow.querySelector('.modal-content');
        if (modalContent) {
            modalContent.scrollTop = 0; // reseta o scroll do conteúdo
        }
    }

    if (battleWindow) {
        battleWindow.addEventListener('click', function (event) {
            // if (event.target === battleWindow) closeBattleWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) showAbandonBattleConfirmation();
        });
    }

    function clearEnemiesTable() {
        const enemiesTable = document.getElementById('enemies-table');
        enemiesTable.innerHTML = '';
    }

    let battle = {};

    battle.turn = 1;
});

