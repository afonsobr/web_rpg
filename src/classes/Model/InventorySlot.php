<?php
namespace TamersNetwork\Model;

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
}
?>