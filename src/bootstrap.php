<?php

// CAMADA DE SEGURANÇA
define('APP_RUNNING', true);

// Habilita a exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * =================================================================
 * NOSSO AUTOLOADER MANUAL (Substituto do 'vendor/autoload.php')
 * =================================================================
 */
spl_autoload_register(function ($className) {
    // O PHP nos dá o nome completo da classe, incluindo o namespace.
    // Exemplo: $className = "DigimonWorld\Repository\AccountRepository"

    // 1. Define o prefixo do nosso namespace e o diretório base
    $namespacePrefix = 'TamersNetwork\\';
    $baseDirectory = __DIR__ . '/classes/'; // __DIR__ aponta para a pasta 'src'

    // 2. Verifica se a classe usa o nosso namespace
    $len = strlen($namespacePrefix);
    if (strncmp($namespacePrefix, $className, $len) !== 0) {
        // Se não for uma classe do nosso projeto, não fazemos nada.
        return;
    }

    // 3. Obtém o nome relativo da classe
    // Ex: "Repository\AccountRepository"
    $relativeClass = substr($className, $len);

    // 4. Constrói o caminho do arquivo
    // Substitui as barras invertidas do namespace por barras de diretório
    // e adiciona a extensão .php
    // Ex: src/Repository/AccountRepository.php
    $file = $baseDirectory . str_replace('\\', '/', $relativeClass) . '.php';

    // 5. Se o arquivo existir, carrega-o
    if (file_exists($file)) {
        require $file;
    }
});


// O resto do seu bootstrap continua igual
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// session_destroy();