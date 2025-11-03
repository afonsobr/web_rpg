<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eterion Survivors</title>
    <style>
        body {
            background-color: #222;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* O canvas (nosso "palco") fica centralizado */
        canvas {
            border: 2px solid #fff;
            background: #000;
        }
    </style>
</head>

<body>
    <canvas id="gameCanvas" width="800" height="600"></canvas>

    <script>
        // --- 1. Configuração Inicial ---
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d'); // "ctx" é o nosso pincel para desenhar

        // --- 2. Variáveis do Jogo ---
        let player = {
            x: canvas.width / 2,
            y: canvas.height / 2,
            size: 20,
            speed: 3,
            hp: 100,
            exp: 0,
            level: 1
        };

        let enemies = []; // Array para guardar todos os inimigos
        let projectiles = []; // Array para guardar os projéteis das armas
        let expGems = []; // Array para as gemas de EXP

        let spawnRate = 200; // A cada 200 frames, tenta gerar um inimigo
        let frameCount = 0;

        // --- 3. Controles do Jogador ---
        let keys = {}; // Objeto para guardar as teclas pressionadas
        document.addEventListener('keydown', (e) => { keys[e.key] = true; });
        document.addEventListener('keyup', (e) => { keys[e.key] = false; });

        // --- 4. O Game Loop (O Coração do Jogo) ---
        function gameLoop() {
            // 4.1. Limpa a tela
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // 4.2. Atualiza a lógica (update)
            updatePlayer();
            updateEnemies();
            updateProjectiles();
            checkCollisions();

            // 4.3. Desenha tudo na tela (draw)
            drawPlayer();
            drawEnemies();
            drawProjectiles(); // Esta função agora existe (veja item 6)

            // 4.4. Chama o próximo quadro
            requestAnimationFrame(gameLoop);
        }

        // --- 5. Funções de Lógica (Update) ---
        function updatePlayer() {
            // Lógica de movimento
            if (keys['w'] || keys['ArrowUp']) player.y -= player.speed;
            if (keys['s'] || keys['ArrowDown']) player.y += player.speed;
            if (keys['a'] || keys['ArrowLeft']) player.x -= player.speed;
            if (keys['d'] || keys['ArrowRight']) player.x += player.speed;

            // Limita o jogador dentro da tela
            if (player.x < player.size / 2) player.x = player.size / 2;
            if (player.y < player.size / 2) player.y = player.size / 2;
            if (player.x > canvas.width - player.size / 2) player.x = canvas.width - player.size / 2;
            if (player.y > canvas.height - player.size / 2) player.y = canvas.height - player.size / 2;
        }

        // NOVO: Função para criar inimigos
        function spawnEnemy() {
            let size = 15;
            let x, y;

            // 50% de chance de nascer nos lados (E/D) ou 50% (Cima/Baixo)
            if (Math.random() < 0.5) {
                x = (Math.random() < 0.5) ? 0 - size : canvas.width + size; // Lado E ou D
                y = Math.random() * canvas.height;
            } else {
                x = Math.random() * canvas.width;
                y = (Math.random() < 0.5) ? 0 - size : canvas.height + size; // Cima ou Baixo
            }

            enemies.push({
                x: x,
                y: y,
                size: size,
                speed: 1.5 // Mais lento que o jogador
            });
        }

        // ATUALIZADO: Função para atualizar inimigos
        function updateEnemies() {
            // Gera um novo inimigo
            frameCount++;
            if (frameCount % spawnRate === 0) { // Tenta gerar a cada 'spawnRate' frames
                if (Math.random() < 0.5) { // 50% de chance de realmente gerar
                    spawnEnemy();
                }
                if (spawnRate > 50) spawnRate -= 5; // Aumenta a dificuldade
            }

            // Move todos os inimigos em direção ao jogador
            enemies.forEach(enemy => {
                // Calcula o vetor direção (distância x e y)
                let dx = player.x - enemy.x;
                let dy = player.y - enemy.y;
                // Calcula a distância total (hipotenusa)
                let distance = Math.sqrt(dx * dx + dy * dy);

                // Move o inimigo nessa direção, normalizado pela velocidade
                enemy.x += (dx / distance) * enemy.speed;
                enemy.y += (dy / distance) * enemy.speed;
            });
        }

        function updateProjectiles() {
            // (Vazio por enquanto)
        }

        function checkCollisions() {
            // (Vazio por enquanto)
        }

        // --- 6. Funções de Desenho (Draw) ---
        function drawPlayer() {
            ctx.fillStyle = 'blue';
            ctx.fillRect(player.x - player.size / 2, player.y - player.size / 2, player.size, player.size);
        }

        function drawEnemies() {
            ctx.fillStyle = 'red';
            enemies.forEach(enemy => {
                ctx.fillRect(enemy.x - enemy.size / 2, enemy.y - enemy.size / 2, enemy.size, enemy.size);
            });
        }

        // NOVO: Função que estava faltando
        function drawProjectiles() {
            ctx.fillStyle = 'yellow';
            projectiles.forEach(proj => {
                // (Lógica de desenhar projéteis viria aqui)
            });
        }

        // --- 7. Inicia o Jogo ---
        console.log("Iniciando o loop do jogo...");
        gameLoop();
    </script>

</body>

</html>