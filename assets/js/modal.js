// --- LÓGICA DO MODAL ---

// 1. Pega os elementos do modal no HTML
const modalContainer = document.getElementById('modal-container');
const modalCloseBtn = document.getElementById('modal-close-btn');

/**
 * Função para abrir o modal
 */
function openModal() {
    if (modalContainer) {
        modalContainer.classList.add('active');
    }
}

/**
 * Função para fechar o modal
 */
function closeModal() {
    if (modalContainer) {
        modalContainer.classList.remove('active');
    }
}

// 2. Adiciona os eventos para fechar
if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', closeModal);
}

if (modalContainer) {
    // Fecha o modal se o usuário clicar no fundo escuro (no overlay)
    modalContainer.addEventListener('click', function (event) {
        // Verifica se o clique foi no próprio container e não em um filho (o conteúdo branco)
        if (event.target === modalContainer) {
            closeModal();
        }
    });
}

// Fecha o modal se o usuário pressionar a tecla "Escape"
document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && modalContainer.classList.contains('active')) {
        closeModal();
    }
});