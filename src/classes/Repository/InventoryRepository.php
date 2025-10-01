<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\InventorySlot;
use TamersNetwork\Model\Item;

class InventoryRepository
{
    private readonly string $databaseName;
    private readonly string $databaseFixName;
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->databaseName = 'var_inventory';
        $this->databaseFixName = 'fix_item';
    }

    public function getInventoryByAccountId2(int $accountId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->databaseName . " WHERE account_id = ?");
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            return [];
        }

        return array_map(fn($row) => Item::fromDatabaseRow($row), $rows);
    }

    public function getInventoryByAccountId(int $accountId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->databaseName . '
            INNER JOIN ' . $this->databaseFixName . '
            ON ' . $this->databaseName . '.item_id = ' . $this->databaseFixName . '.item_id
            WHERE account_id = ?');
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $inventoryItems = [];

        foreach ($rows as $row) {
            $item = Item::fromDatabaseRow($row);
            $inventoryItems[] = InventorySlot::fromDatabaseRow($item, $row);
        }

        return $inventoryItems;
    }


    public function getSingleItemById(int $id): ?Item
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->databaseName . " WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? Item::fromDatabaseRow($row) : null;
    }


}