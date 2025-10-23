<?php
namespace TamersNetwork\Model;

class Item
{
    public function __construct(
        public readonly int $itemId,
        public string $name,
        public string $icon,
        public bool $isStackable,
        public string $description,
        public string $type1,
        public string $type2,
        public string $stats,
        public string $lore,
    ) {
    }
    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            itemId: $data['item_id'],
            name: $data['name'],
            icon: $data['icon'],
            isStackable: (bool) $data['is_stackable'],
            description: $data['description'],
            type1: $data['type1'],
            type2: $data['type2'],
            stats: $data['stats'],
            lore: $data['lore'],
        );
    }
}
?>