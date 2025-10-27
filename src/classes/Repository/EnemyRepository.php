<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\Enemy;
use TamersNetwork\Model\Spawn;

class EnemyRepository
{
    private readonly string $dbDigimonData;
    private readonly string $dbEnemy;
    private readonly string $dbSpawn;
    private readonly TraitRepository $traitRepository;
    public function __construct(private PDO $pdo)
    {
        $this->dbDigimonData = 'fix_digidex';
        $this->dbEnemy = 'fix_enemies';
        $this->dbSpawn = 'fix_spawns';
        $this->traitRepository = new TraitRepository($pdo);
    }

    public function getEnemyById(int $id): ?Enemy
    {
        $sql = 'SELECT * FROM ' . $this->dbEnemy . '
        INNER JOIN ' . $this->dbDigimonData . '
        ON ' . $this->dbEnemy . '.digimon_id = ' . $this->dbDigimonData . '.digimon_id
        WHERE ' . $this->dbEnemy . '.id = ? 
        LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        $data = $this->traitRepository->getDigimonTraits($data);
        return Enemy::fromDatabaseRow($data);
    }

    public function getRandomEnemyByMapSpawn(int $map): ?Spawn
    {
        $sql = '
        SELECT *
        FROM ' . $this->dbSpawn . ' AS spawn
        INNER JOIN ' . $this->dbEnemy . ' AS enemy
            ON spawn.enemy_id = enemy.enemy_id
        INNER JOIN ' . $this->dbDigimonData . ' AS digidata
            ON enemy.digimon_id = digidata.digimon_id
        WHERE spawn.map = ?
        ORDER BY RAND()
        LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$map]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        $data = $this->traitRepository->getDigimonTraits($data);
        // $enemy = Enemy::fromDatabaseRow($data);
        return Spawn::fromDatabaseRow($data);
    }
}