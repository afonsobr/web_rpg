<!DOCTYPE html>
<html lang="pt-br" class=""> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Base com Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      // Configuração opcional para o modo escuro, se você quiser personalizar algo
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            // Suas extensões de tema aqui
          }
        }
      }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">

    <nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 
               flex justify-around items-center h-20
               lg:left-0 lg:top-0 lg:bottom-0 lg:h-auto lg:w-24 lg:flex-col lg:justify-start lg:border-t-0 lg:border-r z-50">

        <div class="hidden lg:flex items-center justify-center w-full h-24 border-b border-gray-200 dark:border-gray-700">
            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>

        <a href="#inicio" class="flex flex-col items-center justify-center p-2 text-blue-600 dark:text-blue-400 lg:w-full lg:py-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-xs font-medium mt-1">Início</span>
        </a>

        <a href="#inventario" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-400 lg:w-full lg:py-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            <span class="text-xs font-medium mt-1">Inventário</span>
        </a>

        <a href="#mercado" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-400 lg:w-full lg:py-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <span class="text-xs font-medium mt-1">Mercado</span>
        </a>

        <a href="#atividade" class="flex flex-col items-center justify-center p-2 text-gray-500 dark:text-gray-400 lg:w-full lg:py-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="text-xs font-medium mt-1">Atividade</span>
        </a>
    </nav>


    <main class="pb-24 lg:pl-24">
        <div class="container mx-auto px-4 py-8">
            
            <h1 class="text-4xl font-bold">Área de Conteúdo</h1>
            <p class="mt-4 text-lg">
                Esta é a área principal onde o conteúdo dinâmico da sua aplicação será carregado. 
                Ela se ajusta automaticamente para dar espaço ao menu de navegação, seja ele inferior ou lateral.
            </p>

            <div class="mt-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold">Exemplo de Card</h2>
                <p class="mt-2">Role a página para ver como o conteúdo não é obstruído pelo menu fixo.</p>
            </div>
            
            <div class="mt-8 space-y-4">
                <div class="h-48 bg-white dark:bg-gray-800 rounded-lg shadow p-4">Bloco de conteúdo 1</div>
                <div class="h-48 bg-white dark:bg-gray-800 rounded-lg shadow p-4">Bloco de conteúdo 2</div>
                <div class="h-48 bg-white dark:bg-gray-800 rounded-lg shadow p-4">Bloco de conteúdo 3</div>
                <div class="h-48 bg-white dark:bg-gray-800 rounded-lg shadow p-4">Bloco de conteúdo 4</div>
                <div class="h-48 bg-white dark:bg-gray-800 rounded-lg shadow p-4">Bloco de conteúdo 5</div>
            </div>
            </div>
    </main>

</body>
</html>