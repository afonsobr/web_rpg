<?php
namespace TamersNetwork\Model;

class Digimon
{
    public function __construct(
        public readonly int $id,
        public int $digimonId,
        public int $accountId,
        public string $nickname,
        public Digimon $digimon,
        public bool $isPartner,
        public bool $isBlocked,
        public int $level,
        public int $exp,
        public int $mapHp,
        public int $currentHp,
        public int $maxDs,
        public int $currentDs,
        public int $size,
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
        public int $hatchedAt,
        public int $updatedAt,
    ) {
    }
}
?>