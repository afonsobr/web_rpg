<?php
namespace TamersNetwork\Model;

class TraitSpecific
{
    public function __construct(
        public readonly int $id,
        public string $name,
        public string $description,
        public string $icon,
        public string $type,
        public int $chance,
        public int $multiplier
    ) {
    }

    public static function fromDatabaseRow(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: $data['name'],
            description: $data['description'],
            icon: $data['icon'],
            type: $data['type'],
            chance: $data['chance'],
            multiplier: $data['multiplier'],
        );
    }
}
?>