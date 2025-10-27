<?php
namespace TamersNetwork\Model;

class Spawn
{


    public int $expReward;
    public int $bitReward;
    public array $itemRewardList;
    public function __construct(
        public Enemy $enemy,
    ) {
        $this->calculateRewards();
    }

    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            enemy: Enemy::fromDatabaseRow($data),
        );
    }

    public function calculateRewards()
    {
        $baseValuesFromClass = [
            1 => 2,
            2 => 4,
            3 => 8,
            4 => 16,
            5 => 32,
        ];

        $this->expReward = floor($baseValuesFromClass[$this->enemy->enemyClass] * (1 + $this->enemy->level) * 5);
        $this->bitReward = ceil(max(1, ($baseValuesFromClass[$this->enemy->enemyClass]) * (1 + $this->enemy->level) / 10));
        $this->bitReward = ceil(mt_rand(190, 255) * $this->bitReward / 200);
    }
}
?>