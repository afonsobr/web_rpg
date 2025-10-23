// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    let digimonIdWindow = 0;
    const digimonWindow = document.getElementById('digimon-window');

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openDigimonWindow = async function (id) {
        if (!digimonWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/digimon_window', '#digimon-window-content', { id: id });

            // Reset modal scroll
            const modalContent = digimonWindow.querySelector('#digimon-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            digimonWindow.classList.add('active');
            // Ajuste do Scroll do Body
            const scrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
        } catch (error) {
            console.error("Erro ao abrir a janela do Digimon:", error);
        }
    };


    window.closeDigimonWindow = function () {
        if (digimonWindow) {
            digimonWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (digimonWindow) {
        digimonWindow.addEventListener('click', function (event) {
            if (event.target === digimonWindow) closeDigimonWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeDigimonWindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && digimonWindow.classList.contains('active')) {
            closeDigimonWindow();
        }
    });
});


/**
 * Filtra a lista de itens do inventário.
 * Esta função é chamada pelo listener de eventos global em game.php.
 */
function filterStorage() {
    const input = document.getElementById('storage-search-input');
    if (!input) return; // Se o input não está na página, não faz nada.

    const searchTerm = input.value.toLowerCase().trim();
    const items = document.querySelectorAll('#storage-list-container .digimon-card');

    items.forEach(item => {
        const itemNameElement = item.querySelector('.digimon-name');
        if (itemNameElement) {
            const itemName = itemNameElement.textContent.toLowerCase().trim();
            if (itemName.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

function toggleAditionalInfo() {
    const ai = document.getElementById('aditional-info');
    ai.classList.toggle('show');
}


function confirmEvolution(lineId) {
    showConfirmationModal('Confirm Evolution to selected Digimon?',
        () => {
            evolvePartner(lineId)
        },
        () => {
        });
}

async function evolvePartner(lineId) {
    try {
        showLoadingModal('Loading...');
        // Usa fetchContent global
        const result = await apiRequest('api/api_digimon', { action: 'evolveDigimon', lineId: lineId });
        await fetchContent(`pages/map`, '.conteudo-principal');
        // navigateTo('map');
        hideLoadingModal();
        showAlertModal(result.message, () => { })
    } catch (error) {
        console.error("Erro ao abrir a janela do Item:", error);
    }
}