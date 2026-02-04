async function restInDigimonInn() {
    showLoadingModal('You and your partner are resting...');

    setTimeout(async () => {
        showLoadingModal('You and your partner wake up well-rested.');

        const result = await apiRequest('api/api_recover', {
            action: 'recoverInInn'
        });

        setTimeout(() => {
            hideLoadingModal();
            showAlertModal(
                `<div class="text-lg pb-1"><b>Inn Rest</b></div>
                You and your partner wake up feeling refreshed.<br>
                HP and DS have been fully restored.`
            );
        }, 2000);

    }, 8000);
}

async function selectDataForHatch(inventoryId) {
    await apiRequest('api/api_hatch', { action: 'selectDataForHatch', inventoryId: inventoryId });
    await fetchContent('pages/map', '.conteudo-principal');
    closeSelectDataWindow();
}

document.addEventListener('DOMContentLoaded', function () {
    const selectEquipmentWindow = document.getElementById('select-equipment-window');

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openSelectDataWindow = async function () {
        if (!selectEquipmentWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/select_data_window', '#select-equipment-window-content', {});

            // Reset modal scroll
            const modalContent = selectEquipmentWindow.querySelector('#select-equipment-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            selectEquipmentWindow.classList.add('active');
            // Ajuste do Scroll do Body
            const scrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
        } catch (error) {
            console.error("Erro ao abrir a janela do SelectEquipment:", error);
        }
    };

    window.closeSelectDataWindow = function () {
        if (selectEquipmentWindow) {
            selectEquipmentWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (selectEquipmentWindow) {
        selectEquipmentWindow.addEventListener('click', function (event) {
            if (event.target === selectEquipmentWindow) closeSelectDataWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeSelectDataWindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && selectEquipmentWindow.classList.contains('active')) {
            closeSelectDataWindow();
        }
    });
});
