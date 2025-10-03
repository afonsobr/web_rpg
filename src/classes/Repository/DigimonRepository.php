<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\DigimonData;
use TamersNetwork\Model\Digimon;
use TamersNetwork\Model\TraitCommon;
use TamersNetwork\Model\TraitSpecific;

class DigimonRepository
{
    private readonly string $databaseVarName;
    private readonly string $databaseFixName;
    private readonly TraitRepository $traitRepository;
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->databaseFixName = 'fix_digidex';
        $this->databaseVarName = 'var_digimons';
        $this->traitRepository = new TraitRepository($pdo);
    }

    public function getDigimonData(int $digimonId): ?DigimonData
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseFixName . ' WHERE digimon_id = ?');
        $stmt->execute([$digimonId]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return DigimonData::fromDatabaseRow($data);
    }

    public function getDigimonById(int $id): ?Digimon
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseVarName . '
        INNER JOIN ' . $this->databaseFixName . '
        ON ' . $this->databaseVarName . '.digimon_id = ' . $this->databaseFixName . '.digimon_id
        WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        $data = $this->getDigimonTraits($data);
        return Digimon::fromDatabaseRow($data);
    }

    public function getDigimonsByAccountId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseVarName . '
        INNER JOIN ' . $this->databaseFixName . '
        ON ' . $this->databaseVarName . '.digimon_id = ' . $this->databaseFixName . '.digimon_id
        WHERE account_id = ?
        ORDER BY ' . $this->databaseVarName . '.digimon_id ASC');
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $digimonList = [];

        foreach ($rows as $row) {
            $digimon = $this->getDigimonTraits($row);
            $digimonList[] = Digimon::fromDatabaseRow($digimon);
        }

        return $digimonList;
    }

    public function getDigimonTraits(array $data): array
    {
        $traitCommon = [];
        foreach (['trait_common_1', 'trait_common_2', 'trait_common_3'] as $col) {
            if (!empty($data[$col])) {
                $traitCommon[] = $this->traitRepository->getCommonTrait($data[$col]);
            }
        }
        $data['trait_common'] = $traitCommon;

        $traitSpecific = [];
        foreach (['trait_specific_1', 'trait_specific_2', 'trait_specific_3'] as $col) {
            if (!empty($data[$col])) {
                $traitSpecific[] = $this->traitRepository->getSpecificTrait($data[$col]);
            }
        }
        $data['trait_specific'] = $traitSpecific;

        return $data;
    }


    public function saveInformation(Digimon $digimon): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->databaseVarName} SET 
                    level = :level,
                    exp = :exp,
                    current_hp = :currentHp,
                    max_hp = :maxHp,
                    current_ds = :currentDs,
                    max_ds = :maxDs,
                    -- adicione outras colunas que você queira atualizar --
                WHERE id = :id"
        );

        return $stmt->execute([
            ':level' => $digimon->level,
            ':exp' => $digimon->exp,
            ':currentHp' => $digimon->currentHp,
            ':maxHp' => $digimon->maxHp,
            ':currentDs' => $digimon->currentDs,
            ':maxDs' => $digimon->maxDs,
            ':id' => $digimon->id
        ]);
    }

    /**
     * Cria um novo Digimon no banco de dados.
     *
     * @param int $accountId ID do tamer dono do Digimon.
     * @param DigimonData $digimonData Os dados base do Digimon a ser criado.
     * @return Digimon|null Retorna o objeto Digimon recém-criado ou nulo em caso de falha.
     */
    public function create(int $accountId, DigimonData $digimonData): ?Digimon
    {
        // Define os valores iniciais para um Digimon recém-chocado
        $sql = "INSERT INTO {$this->databaseVarName} 
                    (digimon_id, account_id, nickname) 
                VALUES 
                    (:digimon_id, :account_id, :nickname)";

        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            ':digimon_id' => $digimonData->digimonId,
            ':account_id' => $accountId,
            ':nickname' => $digimonData->name,
        ]);

        if ($success) {
            // Se a inserção funcionou, pega o ID do novo registro
            $newId = (int) $this->pdo->lastInsertId();

            // Retorna um objeto Digimon completo com os dados inseridos
            // (Você precisará de um método `findById` para fazer isso de forma limpa,
            // mas por agora vamos construir manualmente)
            return $this->getDigimonById($newId);
        }

        return null; // Retorna nulo se a inserção falhar
    }
}