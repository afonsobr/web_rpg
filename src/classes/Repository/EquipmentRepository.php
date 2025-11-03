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
                    var_equipments.slot_name,
                    var_equipments.inventory_id,
                    fix_item.*,
                    var_inventory.*
                FROM {$this->dbEquipment} var_equipments
                INNER JOIN {$this->dbInventory} var_inventory ON var_equipments.inventory_id = var_inventory.id
                INNER JOIN {$this->dbItem} fix_item ON var_inventory.item_id = fix_item.item_id
                WHERE var_equipments.account_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$accountId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $equippedItems = [];
        foreach ($rows as $row) {
            $slotName = $row['slot_name'];
            // Remove slot_name para passar apenas dados do Item para fromDatabaseRow
            unset($row['slot_name']);
            $item = Item::fromDatabaseRow($row);
            $equippedItems[$slotName] = InventorySlot::fromDatabaseRow($item, $row);
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