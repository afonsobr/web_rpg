<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\Mail;

class MailRepository
{
    private readonly string $dbMail;
    private readonly TraitRepository $traitRepository;
    public function __construct(private PDO $pdo)
    {
        $this->dbMail = 'var_mail';
        $this->traitRepository = new TraitRepository($pdo);
    }

    public function getAccountMailList(int $account_id): ?array
    {
        $sql = 'SELECT * FROM ' . $this->dbMail . '
        WHERE ' . $this->dbMail . '.account_id = ? ORDER BY ID DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$account_id]);
        $data = $stmt->fetchAll();

        if ($data === false) {
            return null;
        }

        return Mail::fromDatabaseRows($data);
    }

    public function getSingleMail(int $account_id, int $id): ?Mail
    {
        $sql = 'SELECT * FROM ' . $this->dbMail . '
        WHERE ' . $this->dbMail . '.account_id = ? AND ' . $this->dbMail . '.id = ?';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$account_id, $id]);
        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return Mail::fromDatabaseSingleRow($data);
    }
    public function markAsRead(int $id, int $accountId): bool
    {
        $sql = 'UPDATE ' . $this->dbMail . '
            SET is_read = 1
            WHERE id = ? AND account_id = ?';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id, $accountId]);
    }


    public function sendMail(
        int $toAccountId,
        int $fromId,
        string $subject,
        string $message,
        ?string $items = null,
        int $coin = 0
    ): bool {
        $sql = 'INSERT INTO ' . $this->dbMail . ' 
        (account_id, from_id, subject, message, items, coin, is_read, sent_at)
        VALUES (?, ?, ?, ?, ?, ?, 0, ?)';

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $toAccountId,
            $fromId,
            $subject,
            $message,
            $items,
            $coin,
            time()
        ]);
    }

    public function sendSystemMail(int $toAccountId, string $subject, string $message, ?string $items = null, int $coin = 0): bool
    {
        return $this->sendMail($toAccountId, 0, $subject, $message, $items, $coin);
    }
}