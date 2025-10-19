<?php
namespace TamersNetwork\Model;

use TamersNetwork\Helper\Helper;
use TamersNetwork\Repository\EquipmentRepository;

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
        );
    }

    // Método para carregar o equipamento sob demanda (Injeção de Dependência)
    public function getEquipment(EquipmentRepository $repo): Equipment
    {
        // Se precisar armazenar em cache o objeto Equipment na instância Account,
        // adicione uma propriedade $equipment e verifique se já foi carregado.
        return new Equipment($this->id, $repo);
    }
}
?>