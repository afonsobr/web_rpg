<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\DigimonData;
use TamersNetwork\Model\Digimon;
use TamersNetwork\Model\TraitCommon;
use TamersNetwork\Model\TraitSpecific;

class TraitRepository
{
    private readonly string $databaseNameCommon;
    private readonly string $databaseNameSpecific;

    public function __construct(private PDO $pdo)
    {
        $this->databaseNameCommon = 'fix_trait_common';
        $this->databaseNameSpecific = 'fix_trait_specific';
    }

    public function getCommonTrait(int $id): ?TraitCommon
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseNameCommon . ' WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return TraitCommon::fromDatabaseRow($data);
    }

    public function getSpecificTrait(int $id): ?TraitSpecific
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseNameSpecific . ' WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return TraitSpecific::fromDatabaseRow($data);
    }
}