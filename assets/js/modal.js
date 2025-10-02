// modal.js
const modalContainer = document.getElementById('modal-container');

function openModal() {
    if (modalContainer) modalContainer.classList.add('active');
}

function closeModal() {
    if (modalContainer) modalContainer.classList.remove('active');
}

// Fecha ao clicar no overlay
if (modalContainer) {
    modalContainer.addEventListener('click', function (event) {
        if (event.target === modalContainer) closeModal();

        // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
        if (event.target.closest('#modal-close-btn')) closeModal();
    });
}

// Fecha com ESC
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && modalContainer.classList.contains('active')) {
        closeModal();
    }
});
