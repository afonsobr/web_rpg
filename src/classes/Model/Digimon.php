<?php
namespace TamersNetwork\Model;

use TamersNetwork\Repository\DigimonRepository;

class Digimon
{
    public int $attack;
    public int $defense;
    public int $battleRating;
    public int $speed;
    public float $traitRate;
    public float $criticalRate;
    public float $criticalDamage;
    public int $maxExp;
    public function __construct(
        public readonly int $id,
        public int $digimonId,
        public readonly int $accountId,
        public string $nickname,
        public DigimonData $digimonData,
        public bool $isPartner = false,
        public bool $isBlocked = false,
        public int $level = 1,
        public int $exp = 0,
        public int $maxHp = 0,
        public int $currentHp = 0,
        public int $maxDs = 0,
        public int $currentDs = 0,
        public int $size = 100,
        public int $tier = 0,
        public int $statStr = 0,
        public int $statAgi = 0,
        public int $statCon = 0,
        public int $statInt = 0,
        public int $point = 0,
        public int $gymStr = 0,
        public int $gymAgi = 0,
        public int $gymCon = 0,
        public int $gymInt = 0,
        public string $hatchedAt = '',
        public string $updatedAt = '',
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
            accountId: (int) $data['account_id'],
            nickname: $data['nickname'],
            digimonData: DigimonData::fromDatabaseRow($data),
            isPartner: (bool) $data['is_partner'],
            isBlocked: (bool) $data['is_blocked'],
            level: (int) $data['level'],
            exp: (int) $data['exp'],
            maxHp: (int) $data['max_hp'],
            currentHp: (int) $data['current_hp'],
            maxDs: (int) $data['max_ds'],
            currentDs: (int) $data['current_ds'],
            size: (int) $data['size'],
            tier: (int) $data['tier'],
            statStr: (int) $data['stat_str'],
            statAgi: (int) $data['stat_agi'],
            statCon: (int) $data['stat_con'],
            statInt: (int) $data['stat_int'],
            point: (int) $data['point'],
            gymStr: (int) $data['gym_str'],
            gymAgi: (int) $data['gym_agi'],
            gymCon: (int) $data['gym_con'],
            gymInt: (int) $data['gym_int'],
            hatchedAt: $data['hatched_at'],
            updatedAt: $data['updated_at'],
        );
    }

    public function calculateStats(): void
    {
        $baseValues = [
            'rookie' => 20,
            'champion' => 80,
            'ultimate' => 190,
            'mega' => 350,
            'ultra' => 400,
        ];

        $base = $baseValues[$this->digimonData->stage] ?? 20;

        $builds = [
            'statStr' => $this->digimonData->buildStr,
            'statAgi' => $this->digimonData->buildAgi,
            'statCon' => $this->digimonData->buildCon,
            'statInt' => $this->digimonData->buildInt,
        ];

        foreach ($builds as $prop => $build) {
            $this->$prop = $this->level * $build + $base;
        }

        $this->attack = $this->statStr * 2 + $this->statAgi * 1;
        $this->defense = $this->statCon * 2 + $this->statInt * 1;
        $this->battleRating = $this->statAgi * 3 + $this->statInt * 1;
        $this->speed = $this->statAgi * 4;

        $this->maxHp = $this->statStr * 1 + $this->statCon * 3;
        $this->maxDs = $this->statCon * 2 + $this->statCon * 1;

        $this->traitRate = floor($this->statInt / 20);
        $this->criticalDamage = 2;
        $this->criticalRate = 5;

        // Size
        $this->attack = floor($this->size / 100 * $this->attack);
        $this->defense = floor($this->size / 100 * $this->defense);
        $this->battleRating = floor($this->size / 100 * $this->battleRating);
        $this->speed = floor($this->size / 100 * $this->speed);
        $this->maxHp = floor($this->size / 100 * $this->maxHp);
        $this->maxDs = floor($this->size / 100 * $this->maxDs);

        $this->maxExp = $this->getRequiredExp();
    }

    public function addExp(int $amount): void
    {
        $this->exp += $amount;
        $this->checkLevelUp();
    }

    public function checkLevelUp(): void
    {
        while ($this->exp >= $this->getRequiredExp()) {
            $this->exp -= $this->getRequiredExp();
            $this->level++;
            $this->calculateStats(); // recalcula stats após subir de nível
        }
    }

    public function save(DigimonRepository $digimonRepository): bool
    {
        try {
            // Delega a responsabilidade de salvar para o repositório.
            return $digimonRepository->saveInformation($this);
        } catch (\PDOException $e) {
            error_log("Erro ao salvar Digimon (ID: {$this->id}): " . $e->getMessage());
            return false;
        }
    }

    public function getRequiredExp(): int
    {
        return $this->level * 8 + floor(pow(($this->level), 3) * 4);
    }

    private function baseCalcExp(): int
    {
        return $this->level * 8 + floor(pow(($this->level), 3) * 4);

    }
    public function getRequiredExp2(): int
    {
        $expTable = [
            1 => 24,
            2 => 57,
            3 => 103,
            4 => 165,
            5 => 248,
            6 => 358,
            7 => 501,
            8 => 687,
            9 => 928,
            10 => 1238,
            11 => 1634,
            12 => 2139,
            13 => 2781,
            14 => 3594,
            15 => 4622,
            16 => 5916,
            17 => 7543,
            18 => 9584,
            19 => 12140,
            20 => 15335,
            21 => 19322,
            22 => 24290,
            23 => 30473,
            24 => 38158,
            25 => 47698,
            26 => 59527,
            27 => 74180,
            28 => 92313,
            29 => 114732,
            30 => 142425,
            31 => 176608,
            32 => 218766,
            33 => 270723,
            34 => 334712,
            35 => 413468,
            36 => 510338,
            37 => 629416,
            38 => 775714,
            39 => 955353,
            40 => 1175819,
            41 => 1446257,
            42 => 1777838,
            43 => 2184202,
            44 => 2681997,
            45 => 3291541,
            46 => 4037624,
            47 => 4950479,
            48 => 6066970,
            49 => 7432039,
            50 => 9100456,
            51 => 11138959,
            52 => 13628845,
            53 => 16669125,
            54 => 20380366,
            55 => 24909338,
            56 => 30434680,
            57 => 37173792,
            58 => 45391160,
            59 => 55408520,
            60 => 67617184,
            61 => 82492960,
            62 => 100614368,
            63 => 122684624,
            64 => 149558400,
            65 => 182274320,
            66 => 222094240,
            67 => 270551200,
            68 => 329507136,
            69 => 401223392,
            70 => 488445920,
            71 => 594508480,
            72 => 723458240,
            73 => 880207488,
            74 => 1070718208,
            75 => 1302224896,
            76 => 1583505664,
            77 => 1925209472,
        ];
        return $expTable[$this->level] ?? 1925209472;
    }
}
?>