<?php
namespace TamersNetwork\Model;

use TamersNetwork\Repository\InventoryRepository;

class InventorySlot
{
    public function __construct(
        public readonly int $id,
        public Item $item,
        public readonly int $accountId,
        public int $quantity,
        public bool $isBlocked = false,
    ) {
    }

    public static function fromDatabaseRow(Item $item, array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            id: $data['id'],
            item: $item,
            accountId: $data['account_id'],
            quantity: $data['quantity'],
            isBlocked: (bool) ($data['is_blocked'] ?? false)
        );
    }

    public function consumeItem()
    {
        $this->quantity--;
    }

    public function save(Account $account, InventoryRepository $inventoryRepository)
    {
        try {
            // Delega a responsabilidade de salvar para o repositório.
            return $inventoryRepository->saveInventorySlot($account->id, $this);
        } catch (\PDOException $e) {
            error_log("Erro ao salvar INventorySlot (ID: {$this->id}): " . $e->getMessage());
            return false;
        }
    }
}
?>