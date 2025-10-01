<?php
namespace TamersNetwork\Model;

use TamersNetwork\Helper\Helper;

class Account
{
    public int $energy = 100;
    public int $maxExp = 0;
    public string $displayCoin = '';
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
            lastIp: $data['last_ip'],
        );
    }
}
?>