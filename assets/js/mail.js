// digimon.js
document.addEventListener('DOMContentLoaded', function () {

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openMailList = async function () {
        await fetchFunc('pages/mail', '.conteudo-principal');
    }

    window.reOpenMailList = async function () {
        await fetchFunc('pages/mail', '.conteudo-principal', {}, 'GET', false);
    }

    window.openMail = async function (id) {
        await openCommonWindow('pages/mail', '#common-window-content', { mail_id: id });
        await reOpenMailList();
    }
});
