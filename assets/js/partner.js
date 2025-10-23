
document.addEventListener('DOMContentLoaded', function () {
    const selectPartnerWindow = document.getElementById('select-partner-window');

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.selectPartner = async function (partnerId) {
        await apiRequest('api/api_digimon', { action: 'setPartner', partnerId: partnerId });
        await fetchContent('pages/home', '.conteudo-principal');
        closeselectPartnerWindow();
    }

    window.openSelectPartnerWindow = async function () {
        if (!selectPartnerWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/select_partner_window', '#select-partner-window-content');

            // Reset modal scroll
            const modalContent = selectPartnerWindow.querySelector('#select-equipment-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            selectPartnerWindow.classList.add('active');
            // Ajuste do Scroll do Body
            const scrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
        } catch (error) {
            console.error("Erro ao abrir a janela do SelectEquipment:", error);
        }
    };

    window.closeselectPartnerWindow = function () {
        if (selectPartnerWindow) {
            selectPartnerWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (selectPartnerWindow) {
        selectPartnerWindow.addEventListener('click', function (event) {
            if (event.target === selectPartnerWindow) closeselectPartnerWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeselectPartnerWindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && selectPartnerWindow.classList.contains('active')) {
            closeselectPartnerWindow();
        }
    });
});
