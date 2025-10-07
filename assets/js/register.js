document.addEventListener('DOMContentLoaded', function () {
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const registrationForm = document.getElementById('registration-form');

    const swiper = new Swiper('.swiper-container', {
        // Impede que o usuário arraste o slide com o dedo/mouse.
        // A navegação será controlada apenas pelos botões.
        allowTouchMove: true, // Mude para 'false' se não quiser que arraste

        // Efeito de transição
        effect: 'fade', // 'slide', 'fade', 'cube', 'coverflow', 'flip'

        on: {
            // Evento que é disparado sempre que o slide muda
            slideChange: function () {
                // Esconde o botão "Voltar" no primeiro slide
                if (swiper.isBeginning) {
                    prevBtn.style.display = 'none';
                } else {
                    prevBtn.style.display = 'block';
                }

                // Esconde o botão "Próximo" e mostra o formulário de submit no último slide
                if (swiper.isEnd) {
                    nextBtn.style.display = 'none';
                } else {
                    nextBtn.style.display = 'block';
                }
            }
        }
    });

    // Ações dos botões
    prevBtn.addEventListener('click', () => {
        swiper.slidePrev();
    });

    nextBtn.addEventListener('click', () => {
        // Validação simples antes de avançar
        const currentSlide = swiper.slides[swiper.activeIndex];
        const input = currentSlide.querySelector('input');

        if (input && input.value.trim() === '') {
            alert('Por favor, preencha o campo para continuar.');
        } else {
            swiper.slideNext();
        }
    });

    // Inicializa o estado dos botões
    prevBtn.style.display = 'none';


    // Previne o envio do formulário com a tecla Enter
    registrationForm.addEventListener('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            // Se não for o último slide, avança ao pressionar Enter
            if (!swiper.isEnd) {
                nextBtn.click();
            }
            return false;
        }
    });
});