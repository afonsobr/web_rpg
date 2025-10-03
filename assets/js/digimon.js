// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    let digimonIdWindow = 0;
    const digimonWindow = document.getElementById('modal-container');

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
            await fetchFunc('pages/digimon_window', '.modal-content', { id: id });
            digimonWindow.classList.add('active');
        } catch (error) {
            console.error("Erro ao abrir a janela do Digimon:", error);
        }
    };
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