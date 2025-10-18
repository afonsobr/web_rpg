<?php
namespace TamersNetwork\Model;

use TamersNetwork\Helper\Helper;

class Account
{
    public int $energy = 100;
    public int $maxExp = 0;
    public string $displayCoin = '';
    public Digimon $partner;
    public function __construct(
        public readonly int $id,
        public string $username,
        public string $email,
        public string $passwordHash,
        public string $lastUpdate,
        public int $level,
        public int $exp,
        public float $coin,
        public int $cash,
        public int $storageSize,
        public int $totalDigimon,
        public string $lastIp,
        public int $equipHatId,
        public int $equipHeadsetId,
        public int $equipGlassesId,
        public int $equipHandsId,
        public int $equipJacketId,
        public int $equipUpperBodyId,
        public int $equipBootsId,
        public int $equipRingId,
        public int $equipBraceletId,
        public int $equipGemId,
        public int $equipBackpackId,
        public int $equipDigiviceId,
        public int $equipChipsetId,
        public int $equipAuraId,
    ) {
        $this->maxExp = 10 + ($level * 5);
        $this->displayCoin = Helper::formatCoinClassic($coin);
    }
    public static function fromDatabaseRow(array $data): self
    {
        // É AQUI que a tradução de snake_case para camelCase acontece agora.
        // Toda a lógica de mapeamento está encapsulada dentro da própria classe.
        return new self(
            id: ($data['id']),
            username: $data['username'],
            email: $data['email'],
            passwordHash: $data['password_hash'],
            lastUpdate: $data['last_update'],
            level: $data['level'],
            exp: $data['exp'],
            coin: $data['coin'],
            cash: $data['cash'],
            storageSize: $data['storage_size'],
            totalDigimon: $data['total_digimon'],
            lastIp: $data['last_ip'],
            equipHatId: $data['equip_hat'],
            equipHeadsetId: $data['equip_headset'],
            equipGlassesId: $data['equip_glasses'],
            equipHandsId: $data['equip_hands'],
            equipJacketId: $data['equip_jacket'],
            equipUpperBodyId: $data['equip_upper_body'],
            equipBootsId: $data['equip_boots'],
            equipRingId: $data['equip_ring'],
            equipBraceletId: $data['equip_bracelet'],
            equipGemId: $data['equip_gem'],
            equipBackpackId: $data['equip_backpack'],
            equipDigiviceId: $data['equip_digivice'],
            equipChipsetId: $data['equip_chipset'],
            equipAuraId: $data['equip_aura'],
        );
    }
}
?>