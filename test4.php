<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ragnarok Mobile Core</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Base e Cores */
        body {
            background-color: #1a202c;
            /* Slate Escuro */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            user-select: none;
            -webkit-user-select: none;
            overflow: hidden;
            color: #e2e8f0;
        }

        /* Fontes estilo RPG */
        .rpg-font {
            font-family: 'Georgia', serif;
        }

        /* Scrollbar Discreta */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        /* Pixel Art Crisp */
        .ro-sprite img {
            image-rendering: pixelated;
        }
    </style>
</head>

<body>

    <div class="flex flex-col h-[100dvh] w-full max-w-md mx-auto bg-[#1e293b] border-x border-gray-700 shadow-2xl relative">

        <header class="h-18 py-2 bg-[#0f172a]/95 backdrop-blur border-b border-gray-700 flex items-center justify-between px-4 shrink-0 z-30 shadow-md">

            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-black/30 rounded-full border border-gray-600 flex items-center justify-center ro-sprite overflow-hidden relative">
                    <div class="absolute inset-0 bg-blue-500/10"></div>
                    <img src="https://cdn.wikimg.net/en/strategywiki/images/a/a3/Male_Crusader_%28Ragnarok_Online%29.png" class="w-full h-full object-contain scale-125 mt-2">
                </div>

                <div class="flex flex-col justify-center">
                    <div class="w-24 h-2 bg-gray-800 rounded overflow-hidden border border-gray-600 relative">
                        <div class="bg-green-600 h-full w-[50%]"></div>
                        <span class="absolute inset-0 text-[8px] flex items-center justify-center text-white font-bold drop-shadow-md"></span>
                    </div>
                    <span class="text-[8px] text-blue-300 font-bold mt-1 tracking-wide">HP: 750 / 1000<br>Lv 5</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="text-right mr-1">
                    <div class="text-yellow-400 font-bold text-sm drop-shadow-sm font-mono">1.250 z</div>
                </div>

                <button onclick="toggleStats()" class="w-10 h-10 bg-gray-800 rounded border border-gray-600 active:scale-95 active:border-blue-500 transition text-blue-300 hover:bg-gray-700">
                    📊
                </button>

                <button onclick="toggleInventory()" class="w-10 h-10 bg-gray-800 rounded border border-gray-600 active:scale-95 active:border-blue-500 transition relative hover:bg-gray-700">
                    🎒
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-gray-800"></span>
                </button>

            </div>
        </header>

        <main id="game-log" class="flex-1 overflow-y-auto custom-scroll p-4 space-y-2 relative">
            <div class="absolute inset-0 opacity-5 pointer-events-none"
                style="background-image: url('https://www.transparenttextures.com/patterns/black-scales.png');">
            </div>

            <div class="text-center py-4 text-gray-500 text-[10px] uppercase tracking-[0.2em] font-bold opacity-60">
                — Payon Cave —
            </div>

            <div class="bg-blue-900/20 border border-blue-500/20 p-2 rounded text-blue-200 text-xs">
                <span class="text-blue-400 font-bold">Sistema:</span> Você entrou na <span class="font-bold text-white">Caverna Payon (Andar 1)</span>. O ar está pesado.
            </div>

            <div class="flex justify-between items-center bg-[#0f172a]/80 p-2 rounded border-l-2 border-blue-500 shadow-sm">
                <span class="text-gray-300 text-xs">Você usou <span class="text-white font-bold">Golpe Fulminante</span> em Bongun!</span>
                <span class="text-white font-bold text-sm text-shadow">124 Dano</span>
            </div>

            <div class="flex justify-between items-center bg-[#0f172a]/80 p-2 rounded border-r-2 border-red-500 shadow-sm">
                <span class="text-red-300 text-xs font-bold">Bongun atacou!</span>
                <span class="text-red-500 font-bold text-sm">-45 HP</span>
            </div>

            <div class="flex justify-center py-2">
                <div class="bg-yellow-900/30 text-yellow-200 text-xs px-3 py-1.5 rounded border border-yellow-500/30 flex items-center gap-2 shadow-sm">
                    ✨ <span class="font-bold">Drop:</span> Maçã de Payon
                </div>
            </div>

            <div class="h-4"></div>
        </main>

        <footer class="bg-[#0f172a] border-t border-gray-700 p-3 shrink-0 shadow-[0_-5px_20px_rgba(0,0,0,0.5)] z-30 pb-6">

            <div class="grid grid-cols-2 gap-2 h-full">
                <button class="bg-gray-700 hover:bg-gray-600 text-gray-200 font-bold py-3 rounded border-b-4 border-gray-900 active:border-b-0 active:translate-y-1 transition text-xs uppercase tracking-wider">
                    Sentar (HP)
                </button>

                <button class="bg-blue-700 hover:bg-blue-600 text-white font-bold py-3 rounded border-b-4 border-blue-900 active:border-b-0 active:translate-y-1 transition text-xs uppercase tracking-wider">
                    Habilidades
                </button>

                <button class="col-span-2 bg-red-700 hover:bg-red-600 text-white font-serif font-bold py-4 rounded border-b-4 border-red-900 active:border-b-0 active:translate-y-1 transition text-lg flex items-center justify-center gap-2 shadow-lg shadow-red-900/20 tracking-widest">
                    ⚔️ ATACAR
                </button>
            </div>

        </footer>

    </div>

    <script>
        const log = document.getElementById('game-log');
        log.scrollTop = log.scrollHeight;
    </script>

</body>

</html>