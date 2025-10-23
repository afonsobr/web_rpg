<?php

namespace TamersNetwork\Repository;

use PDO;
use PDOException;
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

        $data = $this->traitRepository->getDigimonTraits($data);
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

        $data = $this->traitRepository->getDigimonTraits($data);
        return Digimon::fromDatabaseRow($data);
    }

    public function getPartnerByAccountId(int $accountId): ?Digimon
    {
        $sql = 'SELECT * FROM ' . $this->databaseVarName . '
        INNER JOIN ' . $this->databaseFixName . '
        ON ' . $this->databaseVarName . '.digimon_id = ' . $this->databaseFixName . '.digimon_id
        WHERE ' . $this->databaseVarName . '.account_id = ? 
        AND ' . $this->databaseVarName . '.is_partner = 1
        LIMIT 1';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$accountId]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        $data = $this->traitRepository->getDigimonTraits($data);
        return Digimon::fromDatabaseRow($data);
    }


    public function getDigimonsByAccountId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseVarName . '
        INNER JOIN ' . $this->databaseFixName . '
        ON ' . $this->databaseVarName . '.digimon_id = ' . $this->databaseFixName . '.digimon_id
        WHERE account_id = ?
        ORDER BY ' . $this->databaseFixName . '.stage_number DESC, ' . $this->databaseFixName . '.digimon_id DESC');
        $stmt->execute([$id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $digimonList = [];

        foreach ($rows as $row) {
            $digimon = $this->traitRepository->getDigimonTraits($row);
            $digimonList[] = Digimon::fromDatabaseRow($digimon);
        }

        return $digimonList;
    }

    /**
     * Define um novo Digimon como parceiro, garantindo que o antigo seja desmarcado.
     * Utiliza uma transação para garantir a integridade dos dados.
     *
     * @param int $accountId O ID da conta do jogador.
     * @param int $newPartnerId O ID do Digimon (da tabela var_digimons) que será o novo parceiro.
     * @return bool Retorna true em caso de sucesso, false em caso de falha.
     */
    public function setNewPartner(int $accountId, int $newPartnerId): bool
    {
        // Inicia uma transação
        $this->pdo->beginTransaction();

        try {
            // Passo 1: Desmarca TODOS os Digimons da conta como parceiros.
            // Isso garante que não haja parceiros múltiplos se algo deu errado no passado.
            $stmtUnset = $this->pdo->prepare(
                "UPDATE {$this->databaseVarName} SET is_partner = 0 WHERE account_id = ?"
            );
            $stmtUnset->execute([$accountId]);

            // Passo 2: Define o novo Digimon como parceiro.
            // A cláusula WHERE garante que um jogador não possa definir o Digimon de outro jogador como parceiro.
            $stmtSet = $this->pdo->prepare(
                "UPDATE {$this->databaseVarName} SET is_partner = 1 WHERE id = ? AND account_id = ?"
            );
            $stmtSet->execute([$newPartnerId, $accountId]);

            // Se ambas as queries funcionaram, confirma a transação
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            // Se algo deu errado, desfaz todas as alterações
            $this->pdo->rollBack();
            error_log("Erro ao trocar de parceiro: " . $e->getMessage()); // Loga o erro
            return false;
        }
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
                    max_ds = :maxDs
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

    public function saveTrainingInformation(Digimon $digimon): bool
    {
        try {
            $stmt = $this->pdo->prepare("
            UPDATE {$this->databaseVarName}
            SET 
                gym_str = :gym_str,
                gym_agi = :gym_agi,
                gym_con = :gym_con,
                gym_int = :gym_int
            WHERE id = :id
            LIMIT 1
        ");

            return $stmt->execute([
                ':gym_str' => $digimon->gymStr,
                ':gym_agi' => $digimon->gymAgi,
                ':gym_con' => $digimon->gymCon,
                ':gym_int' => $digimon->gymInt,
                ':id' => $digimon->id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar treino do Digimon #{$digimon->id}: " . $e->getMessage());
            return false;
        }
    }

    public function saveEvolution(Digimon $digimon, int $toId): bool
    {
        try {
            $stmt = $this->pdo->prepare("
            UPDATE {$this->databaseVarName}
            SET 
                digimon_id = :digimon_id,
                level = :level,
                exp = :exp
            WHERE id = :id
            LIMIT 1
        ");

            return $stmt->execute([
                ':digimon_id' => $toId,
                ':level' => $digimon->level,
                ':exp' => $digimon->exp,
                ':id' => $digimon->id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar evolução do Digimon #{$digimon->id}: " . $e->getMessage());
            return false;
        }
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