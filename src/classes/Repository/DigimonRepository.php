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
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->databaseFixName = 'fix_digidex';
        $this->databaseVarName = 'var_digimon';
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

        return Digimon::fromDatabaseRow($data);
    }

    public function getCommonTrait(int $id): ?TraitCommon
    {
        $stmt = $this->pdo->prepare('SELECT * FROM fix_trait_common
        WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return TraitCommon::fromDatabaseRow($data);
    }

    public function getSpecificTrait(int $id): ?TraitSpecific
    {
        $stmt = $this->pdo->prepare('SELECT * FROM fix_trait_specific
        WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return TraitSpecific::fromDatabaseRow($data);
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

    public function saveInformation2(Digimon $digimon): bool
    {
        // Converte objeto em array (propriedade => valor)
        $props = get_object_vars($digimon);

        // Define colunas que realmente existem no banco (ajuste conforme sua tabela)
        $allowed = [
            'level',
            'exp',
            'currentHp',
            'maxHp',
            'currentDs',
            'maxDs',
            'size',
            'tier',
            'statStr',
            'statAgi',
            'statCon',
            'statInt',
            'point',
            'gymStr',
            'gymAgi',
            'gymCon',
            'gymInt',
            'isPartner',
            'isBlocked',
            'nickname'
        ];

        // Filtra só as colunas válidas
        $fields = array_intersect_key($props, array_flip($allowed));

        // Monta dinamicamente a query SET
        $setPart = implode(', ', array_map(fn($col) => strtolower(preg_replace('/[A-Z]/', '_$0', $col)) . " = :$col", array_keys($fields)));

        $sql = "UPDATE {$this->databaseVarName} SET $setPart WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        // Adiciona o id no bind
        $fields['id'] = $digimon->id;

        return $stmt->execute($fields);
    }

}