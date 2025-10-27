<?php
namespace TamersNetwork\Model;

class Mail
{
    public string $fromName;

    public function __construct(
        public readonly int $id,
        public readonly int $accountId,
        public readonly int $fromId,
        public string $subject,
        public string $message,
        public ?string $items, // pode ser null se não houver item anexo
        public int $coin,
        public bool $isRead,
        public int $sentAt,
    ) {
        $this->fromName = 'Admin';
    }

    /**
     * Cria uma instância de Mail a partir de um array de dados do banco.
     */
    public static function fromDatabaseSingleRow(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            accountId: (int) $data['account_id'],
            fromId: (int) $data['from_id'],
            subject: $data['subject'] ?? '',
            message: $data['message'] ?? '',
            items: $data['items'] ?? null,
            coin: (int) ($data['coin'] ?? 0),
            isRead: (bool) ($data['is_read'] ?? false),
            sentAt: ($data['sent_at'] ?? time()),
        );
    }

    public static function fromDatabaseRows(array $rows): array
    {
        $mails = [];
        foreach ($rows as $data) {
            $mails[] = new self(
                id: (int) $data['id'],
                accountId: (int) $data['account_id'],
                fromId: (int) $data['from_id'],
                subject: $data['subject'] ?? '',
                message: $data['message'] ?? '',
                items: $data['items'] ?? null,
                coin: (int) ($data['coin'] ?? 0),
                isRead: (bool) ($data['is_read'] ?? false),
                sentAt: ($data['sent_at'] ?? time()),
            );
        }
        return $mails;
    }


}
?>