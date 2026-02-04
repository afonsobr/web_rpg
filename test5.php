<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Digi-Defense: Server Protection</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="game-container">
        <div class="ui-panel">
            <h2>DIGIMON DEFENSE</h2>
            <div class="stats">
                <p>HP: <span id="hp">10</span></p>
                <p>Bits: <span id="bits">100</span></p>
                <p>Wave: <span id="wave">1</span></p>
            </div>
            <div class="controls">
                <button onclick="startGame()">Iniciar Wave</button>
            </div>
        </div>

        <canvas id="gameCanvas" width="800" height="600"></canvas>
    </div>

    <script src="game.js"></script>
</body>

</html>

<style>
    body {
        background-color: #1a1a1a;
        color: #00ffcc;
        /* Verde Ciano Digital */
        font-family: 'Courier New', monospace;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .game-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 2px solid #00ffcc;
        padding: 10px;
        background-color: #000;
    }

    canvas {
        background-color: #2e2e2e;
        border: 1px solid #555;
        cursor: crosshair;
        /* Aqui entraria a imagem de fundo que geramos no prompt anterior */
        /* background-image: url('mapa_digimundo.png'); */
        /* background-size: cover; */
    }

    .ui-panel {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding: 0 20px;
        box-sizing: border-box;
    }

    button {
        background: #00ffcc;
        color: #000;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
        cursor: pointer;
    }

    button:hover {
        background: #fff;
    }
</style>

<script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

    // --- CONFIGURAÇÕES ---
    const TILE_SIZE = 40; // Cada quadrado tem 40x40 pixels
    const COLS = 20;
    const ROWS = 15;

    // Estado do Jogo
    let bits = 100;
    let lives = 10;
    let wave = 1;
    let gameLoopId;

    // Listas de Objetos
    const enemies = [];
    const towers = [];
    const projectiles = [];

    // MAPA (0 = Grama/Construível, 1 = Caminho)
    // Um grid simples onde 1 desenha o caminho.
    const mapGrid = [
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0],
        [0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0],
        [0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0],
        [0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
    ];

    // Waypoints (Pontos de virada baseados no Grid acima)
    // Coordenadas X, Y do centro dos blocos de caminho
    const waypoints = [
        { x: 0, y: 1 }, { x: 4, y: 1 }, { x: 4, y: 4 }, { x: 8, y: 4 }, { x: 8, y: 2 },
        { x: 12, y: 2 }, { x: 12, y: 4 }, { x: 17, y: 4 }, { x: 17, y: 9 }, { x: 8, y: 9 },
        { x: 8, y: 7 }, { x: 2, y: 7 }, { x: 2, y: 11 }, { x: 5, y: 11 }, { x: 5, y: 13 }, { x: 15, y: 13 }
    ];

    // --- CLASSES ---

    class Enemy {
        constructor() {
            this.wpIndex = 0;
            // Começa no primeiro waypoint
            this.x = waypoints[0].x * TILE_SIZE + TILE_SIZE / 2;
            this.y = waypoints[0].y * TILE_SIZE + TILE_SIZE / 2;
            this.speed = 2;
            this.hp = 100;
            this.radius = 10;
            this.alive = true;
        }

        update() {
            // Lógica de movimento simples waypoint a waypoint
            const target = waypoints[this.wpIndex + 1];
            if (!target) {
                this.alive = false; // Chegou ao fim
                lives--;
                document.getElementById('hp').innerText = lives;
                return;
            }

            const tx = target.x * TILE_SIZE + TILE_SIZE / 2;
            const ty = target.y * TILE_SIZE + TILE_SIZE / 2;

            const dx = tx - this.x;
            const dy = ty - this.y;
            const dist = Math.hypot(dx, dy);

            if (dist < this.speed) {
                this.x = tx;
                this.y = ty;
                this.wpIndex++;
            } else {
                this.x += (dx / dist) * this.speed;
                this.y += (dy / dist) * this.speed;
            }
        }

        draw() {
            ctx.fillStyle = 'red';
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fill();
            // Barra de vida
            ctx.fillStyle = 'white';
            ctx.fillRect(this.x - 10, this.y - 15, 20, 4);
            ctx.fillStyle = 'green';
            ctx.fillRect(this.x - 10, this.y - 15, 20 * (this.hp / 100), 4);
        }
    }

    class Tower {
        constructor(c, r) {
            this.c = c; // Coluna Grid
            this.r = r; // Linha Grid
            this.x = c * TILE_SIZE + TILE_SIZE / 2;
            this.y = r * TILE_SIZE + TILE_SIZE / 2;
            this.range = 100;
            this.cooldown = 0;
            this.fireRate = 40; // Frames entre tiros
        }

        update() {
            if (this.cooldown > 0) this.cooldown--;

            if (this.cooldown <= 0) {
                // Achar inimigo mais próximo
                for (const enemy of enemies) {
                    const dist = Math.hypot(enemy.x - this.x, enemy.y - this.y);
                    if (dist <= this.range) {
                        this.shoot(enemy);
                        this.cooldown = this.fireRate;
                        break;
                    }
                }
            }
        }

        shoot(target) {
            projectiles.push(new Projectile(this.x, this.y, target));
        }

        draw() {
            // Desenhar a torre (ex: quadrado azul)
            ctx.fillStyle = 'cyan';
            ctx.fillRect(this.c * TILE_SIZE + 5, this.r * TILE_SIZE + 5, TILE_SIZE - 10, TILE_SIZE - 10);
        }
    }

    class Projectile {
        constructor(x, y, target) {
            this.x = x;
            this.y = y;
            this.target = target;
            this.speed = 8;
            this.damage = 25;
            this.active = true;
        }

        update() {
            if (!this.target.alive) {
                this.active = false;
                return;
            }

            const dx = this.target.x - this.x;
            const dy = this.target.y - this.y;
            const dist = Math.hypot(dx, dy);

            if (dist < this.speed) {
                this.target.hp -= this.damage;
                if (this.target.hp <= 0) {
                    this.target.alive = false;
                    bits += 15; // Ganha Bits
                    document.getElementById('bits').innerText = bits;
                }
                this.active = false; // Tiro some
            } else {
                this.x += (dx / dist) * this.speed;
                this.y += (dy / dist) * this.speed;
            }
        }

        draw() {
            ctx.fillStyle = 'yellow';
            ctx.beginPath();
            ctx.arc(this.x, this.y, 4, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    // --- FUNÇÕES DO JOGO ---

    function drawMap() {
        for (let r = 0; r < ROWS; r++) {
            for (let c = 0; c < COLS; c++) {
                if (mapGrid[r][c] === 1) {
                    // Caminho
                    ctx.fillStyle = '#333';
                    ctx.fillRect(c * TILE_SIZE, r * TILE_SIZE, TILE_SIZE, TILE_SIZE);
                } else {
                    // Grama/Construível (Grid visual)
                    ctx.strokeStyle = '#004433';
                    ctx.strokeRect(c * TILE_SIZE, r * TILE_SIZE, TILE_SIZE, TILE_SIZE);
                }
            }
        }
    }

    function gameLoop() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        drawMap();

        // Update e Draw Inimigos
        for (let i = enemies.length - 1; i >= 0; i--) {
            const e = enemies[i];
            e.update();
            e.draw();
            if (!e.alive) enemies.splice(i, 1);
        }

        // Update e Draw Torres
        towers.forEach(t => {
            t.update();
            t.draw();
        });

        // Update e Draw Projéteis
        for (let i = projectiles.length - 1; i >= 0; i--) {
            const p = projectiles[i];
            p.update();
            p.draw();
            if (!p.active) projectiles.splice(i, 1);
        }

        requestAnimationFrame(gameLoop);
    }

    // --- INTERAÇÃO ---

    // Clique para construir torre
    canvas.addEventListener('mousedown', (e) => {
        const rect = canvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const mouseY = e.clientY - rect.top;

        // Converte pixel para coordenada do grid
        const c = Math.floor(mouseX / TILE_SIZE);
        const r = Math.floor(mouseY / TILE_SIZE);

        // Validações
        if (mapGrid[r][c] === 1) return; // Não pode construir no caminho
        if (bits < 50) return; // Sem dinheiro

        // Verifica se já tem torre
        const exists = towers.find(t => t.c === c && t.r === r);
        if (exists) return;

        // Construir
        towers.push(new Tower(c, r));
        bits -= 50;
        document.getElementById('bits').innerText = bits;
    });

    function startGame() {
        // Spawnar um inimigo a cada 1.5 segundos (simples)
        let enemiesToSpawn = 5 + wave * 2;
        let spawnInterval = setInterval(() => {
            enemies.push(new Enemy());
            enemiesToSpawn--;
            if (enemiesToSpawn <= 0) clearInterval(spawnInterval);
        }, 1500);
    }

    // Inicia o loop visual
    gameLoop();
</script>