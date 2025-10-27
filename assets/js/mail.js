// digimon.js
document.addEventListener('DOMContentLoaded', function () {
    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openMail = async function () {
        await fetchFunc('pages/mail', '.conteudo-principal', {});
    }
});
