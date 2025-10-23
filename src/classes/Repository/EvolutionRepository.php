<?php

namespace TamersNetwork\Repository;
use TamersNetwork\Model\Account;

use PDO;

class EvolutionRepository
{
    private readonly string $dbEvolution;
    private readonly string $dbDigimon;
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->dbEvolution = 'fix_evolution';
        $this->dbDigimon = 'fix_digidex';
    }

    public function findEvolution(int $digimonId)
    {
        $stmt = $this->pdo->prepare('SELECT 
        * FROM ' . $this->dbEvolution . '
        WHERE from_id = ?');
        // $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseName . ' WHERE username = ?');
        $stmt->execute([$digimonId]);
        $data = $stmt->fetchAll();

        return ($data);
    }

    public function findEvolutionByLineId(int $line_id)
    {
        $stmt = $this->pdo->prepare('SELECT 
        * FROM ' . $this->dbEvolution . '
        WHERE id = ?');
        // $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseName . ' WHERE username = ?');
        $stmt->execute([$line_id]);
        $data = $stmt->fetch();

        return ($data);
    }



}