<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\InventorySlot;
use TamersNetwork\Model\Item;

class InventoryRepository
{
    private readonly string $dbInventory;
    private readonly string $dbItem;
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->dbInventory = 'var_inventory';
        $this->dbItem = 'fix_item';
    }

    public function getInventoryByAccountId2(int $accountId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->dbInventory . " WHERE account_id = ?");
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return [];
        }

        return array_map(fn($row) => Item::fromDatabaseRow($row), $rows);
    }

    public function getInventoryByAccountId(int $accountId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->dbInventory . '
            INNER JOIN ' . $this->dbItem . '
            ON ' . $this->dbInventory . '.item_id = ' . $this->dbItem . '.item_id
            WHERE account_id = ? ORDER BY ' . $this->dbInventory . '.item_id');
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $inventoryItems = [];

        foreach ($rows as $row) {
            $item = Item::fromDatabaseRow($row);
            $inventoryItems[] = InventorySlot::fromDatabaseRow($item, $row);
        }

        return $inventoryItems;
    }

    public function getSingleInventoryItemByInventoryId(int $accountId, int $inventoryId): InventorySlot
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->dbInventory . '
            INNER JOIN ' . $this->dbItem . '
            ON ' . $this->dbInventory . '.item_id = ' . $this->dbItem . '.item_id
            WHERE account_id = ? and ' . $this->dbInventory . '.id = ?');
        $stmt->execute([$accountId, $inventoryId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $item = Item::fromDatabaseRow($row);
        $returnItem = InventorySlot::fromDatabaseRow($item, $row);

        return $returnItem;
    }

    public function getSingleItemById(int $id): ?Item
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->dbInventory . " WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? Item::fromDatabaseRow($row) : null;
    }


    /**
     * Atualiza a quantidade e o status de bloqueio de um item no inventário.
     *
     * @param int $accountId O ID da conta para segurança.
     * @param InventorySlot $inventorySlot O objeto do slot de inventário com os novos valores.
     * @return bool Retorna true se a atualização foi bem-sucedida, false caso contrário.
     */
    public function saveInventorySlot(int $accountId, InventorySlot $inventorySlot): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE {$this->dbInventory}
            SET quantity = ?, is_blocked = ?
            WHERE account_id = ? AND id = ?"
        );

        // O método execute() já retorna true em caso de sucesso e false em caso de falha.
        // A linha com fetch() foi removida por ser desnecessária para um UPDATE.
        return $stmt->execute([
            $inventorySlot->quantity,
            (int) $inventorySlot->isBlocked, // Converte o booleano para 0 ou 1 para o banco de dados
            $accountId,
            $inventorySlot->id
        ]);
    }

    public function addItem(int $accounId, Item $itemObj, int $itemQuantity)
    {
        // adiciona o item no inventario
    }
}