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

    window.openDigimonWindow = async function () {
        if (!digimonWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/digimon_window', '.modal-content');
            digimonWindow.classList.add('active');
        } catch (error) {
            console.error("Erro ao abrir a janela do Digimon:", error);
        }
    };
});
