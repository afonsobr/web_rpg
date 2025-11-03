<?php
namespace TamersNetwork\Model;

class Enemy
{

    public int $attack;
    public int $defense;
    public int $battleRating;
    public int $speed;
    public int $statStr = 0;
    public int $statAgi = 0;
    public int $statCon = 0;
    public int $statInt = 0;
    public int $size = 100;
    public int $maxHp = 0;
    public int $currentHp = 0;
    public int $maxDs = 0;
    public int $currentDs = 0;
    public int $hpPercent = 100;
    public float $traitRate;
    public float $criticalRate;
    public float $criticalDamage;
    public function __construct(
        public readonly int $id,
        public int $enemyClass,
        public int $digimonId,
        public int $level,
        public DigimonData $digimonData,
    ) {
        $this->calculateStats();
    }

    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            id: (int) $data['id'],
            digimonId: (int) $data['digimon_id'],
            enemyClass: (int) $data['enemy_class'],
            level: (int) $data['level'],
            digimonData: DigimonData::fromDatabaseRow($data),
        );
    }

    public function calculateStats(): void
    {
        $baseValuesFromStage = [
            'rookie' => 20,
            'champion' => 80,
            'ultimate' => 190,
            'mega' => 350,
            'ultra' => 400,
        ];

        $baseFromStage = $baseValuesFromStage[$this->digimonData->stage] ?? 20;

        $baseValuesFromClass = [
            1 => 0,
            2 => 80,
            3 => 190,
            4 => 350,
            5 => 400,
        ];

        $baseFromClass = $baseValuesFromClass[$this->enemyClass] ?? 10;

        $builds = [
            'statStr' => $this->digimonData->buildStr,
            'statAgi' => $this->digimonData->buildAgi,
            'statCon' => $this->digimonData->buildCon,
            'statInt' => $this->digimonData->buildInt,
        ];

        foreach ($builds as $prop => $build) {
            $this->$prop = $this->level * $build + $baseFromStage + $baseFromClass;
        }

        $this->attack = $this->statStr * 2 + $this->statAgi * 1;
        $this->defense = $this->statCon * 2 + $this->statInt * 1;
        $this->battleRating = $this->statAgi * 3 + $this->statInt * 1;
        $this->speed = $this->statAgi * 4;

        $this->maxHp = $this->statStr * 1 + $this->statCon * 3;
        $this->maxDs = $this->statCon * 2 + $this->statCon * 1;

        $this->traitRate = 1 + floor($this->statInt / 30);
        $this->criticalDamage = 2;
        $this->criticalRate = 5;

        // Size
        $this->attack = floor($this->size / 100 * $this->attack);
        $this->defense = floor($this->size / 100 * $this->defense);
        $this->battleRating = floor($this->size / 100 * $this->battleRating);
        $this->speed = floor($this->size / 100 * $this->speed);
        $this->maxHp = floor($this->size / 100 * $this->maxHp);
        $this->maxDs = floor($this->size / 100 * $this->maxDs);

        // Inicia HP e DS
        $this->currentHp = $this->maxHp;
        $this->currentDs = $this->maxDs;
    }

    public function getHpPercent()
    {
        $this->hpPercent = ceil($this->currentHp / $this->maxHp * 100);
        return $this->hpPercent;
    }
}
?>