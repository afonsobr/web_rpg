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
                <div class="d-flex w-100 justify-center items-center">
                    <div class="font-normal nowrap pr-3">Analyzing & Searching...</div>
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
            enemiesTable.innerHTML = searchLoading;
            // Espera 3 segundos antes de buscar os inimigos
            setTimeout(async () => {
                if (!enemiesTable) return;
                await fetchFunc('api/api_search_enemies', '#enemies-table');
                searchEnemieBtn.classList.remove('disabled');
            }, 10); //1500
        } catch (error) {
            console.error("Erro ao abrir a janela do Digimon:", error);
        }
    };

    const confirmModal = document.getElementById('confirm-modal');

    // Exibe o modal de confirmação e configura callbacks
    function showConfirmationModal(message, onConfirm, onCancel) {
        const modal = document.getElementById('confirm-modal');
        const questionDiv = modal.querySelector('#question-div');
        const yesBtn = modal.querySelector('#yes-div');
        const noBtn = modal.querySelector('#no-div');

        // Define mensagem e exibe modal
        questionDiv.textContent = message;
        // modal.hidden = false;
        modal.querySelector('#yes-div').classList.remove('disabled');
        modal.querySelector('#no-div').classList.remove('disabled');
        modal.classList.add('active');


        // Remove eventos antigos para evitar duplicação
        yesBtn.replaceWith(yesBtn.cloneNode(true));
        noBtn.replaceWith(noBtn.cloneNode(true));

        // Pega os novos botões após o clone
        const newYesBtn = modal.querySelector('#yes-div');
        const newNoBtn = modal.querySelector('#no-div');

        // Atribui novos eventos
        newYesBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.querySelector('#yes-div').classList.add('disabled');
            if (typeof onConfirm === 'function') onConfirm();
        });

        newNoBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            modal.querySelector('#no-div').classList.add('disabled');
            if (typeof onCancel === 'function') onCancel();
        });
    };

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
        await fetchFunc('pages/battle', '#battle-window-content');
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

