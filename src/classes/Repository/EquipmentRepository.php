<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\InventorySlot;
use TamersNetwork\Model\Item;

class EquipmentRepository
{
    private readonly string $dbEquipment;
    private readonly string $dbInventory;
    private readonly string $dbItem;
    private readonly InventoryRepository $inventoryRepository; // Pode ser útil

    public function __construct(private PDO $pdo)
    {
        $this->dbEquipment = 'var_equipments';
        $this->dbInventory = 'var_inventory';
        $this->dbItem = 'fix_item';
        // Poderíamos injetar o InventoryRepository se precisarmos buscar
        // detalhes do InventorySlot, mas vamos buscar o Item diretamente por enquanto.
        $this->inventoryRepository = new InventoryRepository($pdo);
    }
    /**
     * Busca todos os itens equipados por um Tamer.
     * Retorna um array associativo [slot_name => Item Object]
     *
     * @param int $accountId
     * @return array<string, ?Item>
     */
    public function findByAccountId(int $accountId): array
    {
        $sql = "SELECT
                    te.slot_name,
                    fi.* -- Seleciona todas as colunas de fix_item
                FROM {$this->dbEquipment} te
                INNER JOIN {$this->dbInventory} vi ON te.inventory_id = vi.id
                INNER JOIN {$this->dbItem} fi ON vi.item_id = fi.item_id
                WHERE te.account_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $equippedItems = [];
        foreach ($rows as $row) {
            $slotName = $row['slot_name'];
            // Remove slot_name para passar apenas dados do Item para fromDatabaseRow
            unset($row['slot_name']);
            $equippedItems[$slotName] = Item::fromDatabaseRow($row);
        }

        return $equippedItems; // Ex: ['hat' => ItemObject, 'boots' => ItemObject, ...]
    }

    // Você precisará de métodos para equipar (save/update) e desequipar (delete) itens também.
    // Exemplo:
    public function equipItem(int $accountId, string $slotName, int $inventoryId): bool
    {
        // Primeiro, desequipa qualquer item que já esteja nesse slot (UPSERT)
        $this->unequipItemSlot($accountId, $slotName);

        $sql = "INSERT INTO {$this->dbEquipment} (account_id, slot_name, inventory_id)
                VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$accountId, $slotName, $inventoryId]);
    }

    public function unequipItemSlot(int $accountId, string $slotName): bool
    {
        $sql = "DELETE FROM {$this->dbEquipment} WHERE account_id = ? AND slot_name = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$accountId, $slotName]);
    }

    public function unequipByInventoryId(int $accountId, int $inventoryId): bool
    {
        $sql = "DELETE FROM {$this->dbEquipment} WHERE account_id = ? AND inventory_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$accountId, $inventoryId]);
    }

}