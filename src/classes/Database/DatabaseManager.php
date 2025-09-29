<?php

namespace TamersNetwork\Database;

use PDO;
use PDOException;

class DatabaseManager
{
    private static ?PDO $pdo = null;

    // O construtor é privado para impedir a criação de instâncias com 'new'.
    private function __construct()
    {
    }

    /**
     * Obtém a instância única da conexão PDO.
     */
    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $host = 'localhost';
            $db = 'tamers_network';
            $user = 'root';
            $pass = 'root';

            $dsn = "mysql:host=$host;dbname=$db";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Em produção, logue o erro em vez de exibi-lo
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }
        }

        return self::$pdo;
    }
}