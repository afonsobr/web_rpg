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

    public function getDigimonTraits(array $data): array
    {
        $traitCommon = [];
        foreach (['trait_common_1', 'trait_common_2', 'trait_common_3'] as $col) {
            if (!empty($data[$col])) {
                $traitCommon[] = $this->getCommonTrait($data[$col]);
            }
        }
        $data['trait_common'] = $traitCommon;

        $traitSpecific = [];
        foreach (['trait_specific_1', 'trait_specific_2', 'trait_specific_3'] as $col) {
            if (!empty($data[$col])) {
                $traitSpecific[] = $this->getSpecificTrait($data[$col]);
            }
        }
        $data['trait_specific'] = $traitSpecific;

        return $data;
    }

    private function getCommonTrait(int $id): ?TraitCommon
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseNameCommon . ' WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return TraitCommon::fromDatabaseRow($data);
    }

    private function getSpecificTrait(int $id): ?TraitSpecific
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