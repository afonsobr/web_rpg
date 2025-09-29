<?php

namespace TamersNetwork\Repository;
use TamersNetwork\Model\Account;

use PDO;

class AccountRepository
{
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
    }

    public function findByUsername(string $username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM var_accounts WHERE username = ?");
        $stmt->execute([$username]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return Account::fromDatabaseRow($data);
    }

    public function findById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM var_accounts WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return Account::fromDatabaseRow($data);
    }

    public function save(Account $account): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO accounts (uuid, username, email, password_hash) VALUES (?, ?, ?, ?)"
        );

        // O password já deve vir hasheado para o repositório
        // A lógica de hash fica fora do repositório
        return $stmt->execute([
            $account->uuid,
            $account->username,
            $account->email,
            // Acessar propriedade privada via getter ou reflexão se necessário, 
            // mas para este exemplo, vamos assumir que o hash é passado na criação.
            password_hash('senha_insegura_a_ser_substituida', PASSWORD_DEFAULT)
        ]);
    }
}