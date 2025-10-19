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