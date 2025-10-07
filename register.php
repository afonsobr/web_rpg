<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Tamers Network</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="utilities.css">

    <style>
        /* Estilos específicos para a página de registro */
        .swiper-container {
            width: 100%;
            height: 100vh;
        }

        .swiper-slide {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
        }

        .registration-step {
            width: 100%;
            max-width: 350px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #444;
            background-color: #fff;
            color: white;
            font-size: 1rem;
        }

        .nav-buttons {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 350px;
            display: flex;
            gap: 10px;
        }

        .nav-button {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
        }

        #prev-btn {
            background-color: #333;
            color: white;
        }

        #next-btn {
            background-color: var(--primary-color);
            color: var(--text-color);
        }
    </style>
</head>

<body class="bg-surface">

    <form id="registration-form" action="/src/actions/register_process.php" method="POST">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="registration-step">
                        <h2>Qual o seu email?</h2>
                        <p>Usaremos para login e recuperação de senha.</p>
                        <input type="email" name="email" id="email" placeholder="seu@email.com" required>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="registration-step">
                        <h2>Crie uma senha</h2>
                        <p>Escolha uma senha segura para sua conta.</p>
                        <input type="password" name="password" id="password" placeholder="********" required>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="registration-step">
                        <h2>Como devemos te chamar?</h2>
                        <p>Este será seu nome de Tamer no jogo.</p>
                        <input type="text" name="tamer_name" id="tamer_name" placeholder="Nome do Domador" required>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="registration-step">
                        <h2>Tudo pronto!</h2>
                        <p>Clique em finalizar para criar sua conta e começar a jornada!</p>
                        <button type="submit" class="nav-button" style="background-color: #28a745; color: white; margin-top: 20px;">Finalizar Cadastro</button>
                    </div>
                </div>

            </div>
        </div>
    </form>

    <div class="nav-buttons">
        <button type="button" id="prev-btn" class="nav-button">Voltar</button>
        <button type="button" id="next-btn" class="nav-button">Próximo</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="assets/js/register.js"></script>

</body>

</html>