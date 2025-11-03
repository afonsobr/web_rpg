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

// Exibe o modal de confirmação e configura callbacks
function showAlertModal(message, onConfirm) {
    const modal = document.getElementById('alert-modal');
    const questionDiv = modal.querySelector('#text-div');
    const yesBtn = modal.querySelector('#dismiss-div');

    // Define mensagem e exibe modal
    questionDiv.innerHTML = message;
    // modal.hidden = false;
    modal.querySelector('#dismiss-div').classList.remove('disabled');
    modal.classList.add('active');

    // Remove eventos antigos para evitar duplicação
    yesBtn.replaceWith(yesBtn.cloneNode(true));

    // Pega os novos botões após o clone
    const newYesBtn = modal.querySelector('#dismiss-div');

    // Atribui novos eventos
    newYesBtn.addEventListener('click', () => {
        modal.classList.remove('active');
        modal.querySelector('#dismiss-div').classList.add('disabled');
        if (typeof onConfirm === 'function') onConfirm();
    });
};


// Exibe o modal de confirmação e configura callbacks
function showLoadingModal(message) {
    const modal = document.getElementById('loading-modal');
    const questionDiv = modal.querySelector('#text-div');
    questionDiv.innerHTML = message;

    modal.classList.add('active');
};

function hideLoadingModal() {
    const modal = document.getElementById('loading-modal');
    modal.classList.remove('active');
};


// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    const commonWindow = document.getElementById('common-window');

    window.openCommonWindow = async function (page, target, params) {
        if (!commonWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc(page, target, params);

            // Reset modal scroll
            const modalContent = commonWindow.querySelector('#common-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            commonWindow.classList.add('active');
            // Ajuste do Scroll do Body
            const scrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
        } catch (error) {
            console.error("Erro ao abrir a janela do CommonWindow:", error);
        }
    };


    window.closeCommonWindow = function () {
        if (commonWindow) {
            commonWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (commonWindow) {
        commonWindow.addEventListener('click', function (event) {
            if (event.target === commonWindow) closeCommonWindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeCommonWindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && commonWindow.classList.contains('active')) {
            closeCommonWindow();
        }
    });
});
