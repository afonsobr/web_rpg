<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\Enemy;

class EnemyRepository
{
    private readonly string $dbDigimonData;
    private readonly string $dbEnemy;
    private readonly TraitRepository $traitRepository;
    public function __construct(private PDO $pdo)
    {
        $this->dbDigimonData = 'fix_digidex';
        $this->dbEnemy = 'fix_enemies';
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
}