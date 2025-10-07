// modal.js
const modalContainer = document.getElementById('modal-container');

function openModal() {
    if (modalContainer) {
        modalContainer.classList.add('active');
        document.body.classList.add('modal-open');
    }
}

function closeModal() {
    if (modalContainer) {
        modalContainer.classList.remove('active');

        // Ajuste do Scroll do Body
        const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollY);
    }
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
