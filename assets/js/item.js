// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    const itemWindow = document.getElementById('item-window');

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openItemWindow = async function (inventoryId) {
        if (!itemWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/item_window', '#item-window-content', { inventoryId: inventoryId });

            // Reset modal scroll
            const modalContent = itemWindow.querySelector('#item-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            itemWindow.classList.add('active');
            // Ajuste do Scroll do Body
            if (document.body.style.position != 'fixed') {
                const scrollY = window.scrollY;
                console.log(scrollY);
                document.body.style.position = 'fixed';
                document.body.style.top = `-${scrollY}px`;
            }
        } catch (error) {
            console.error("Erro ao abrir a janela do Item:", error);
        }
    };

    window.protectItem = async function (inventoryId) {
        if (!itemWindow) return;

        try {
            // Usa fetchContent global
            await apiRequest('api/api_item', { action: 'toggleItemProtection', inventoryId: inventoryId });
            openItemWindow(inventoryId);
        } catch (error) {
            console.error("Erro ao abrir a janela do Item:", error);
        }
    };


    window.closeItemWindow = function () {
        if (itemWindow) {
            itemWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (itemWindow) {
        itemWindow.addEventListener('click', function (event) {
            if (event.target === itemWindow) closeItemWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeItemWindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && itemWindow.classList.contains('active')) {
            closeItemWindow();
        }
    });
});

