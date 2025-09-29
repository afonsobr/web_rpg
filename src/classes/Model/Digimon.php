<?php
namespace TamersNetwork\Model;

class Digimon
{
    public function __construct(
        public readonly int $id,
        public string $name,
        public int $digimonId,
        public int $accountId,
        public int $level,
        public int $exp,
        public int $tier,
        public int $statStr,
        public int $statAgi,
        public int $statCon,
        public int $statInt,
        public int $point,
        public int $gymStr,
        public int $gymAgi,
        public int $gymCon,
        public int $gymInt,
    ) {
    }
    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            id: ($data['id']),
            name: $data['name'],
            digimonId: $data['digimon_id'],
            accountId: $data['account_id'],
            level: $data['level'],
            exp: $data['exp'],
            tier: $data['tier'],
            statStr: $data['statStr'],
            statAgi: $data['statAgi'],
            statCon: $data['statCon'],
            statInt: $data['statInt'],
        );
    }


    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
?>