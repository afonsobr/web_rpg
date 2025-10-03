<?php
namespace TamersNetwork\Model;

class TraitCommon
{
    public function __construct(
        public readonly int $id,
        public string $name,
        public string $description,
        public string $icon,
        public ?string $type,
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
            multiplier: $data['multiplier'],
        );
    }
}
?>