<?php

namespace TamersNetwork\Repository;

use PDO;
use TamersNetwork\Model\Item;

class ItemRepository
{
    private readonly string $dbItem;
    // Injetando a dependência do PDO para facilitar testes e clareza
    public function __construct(private PDO $pdo)
    {
        $this->dbItem = 'fix_item';
    }

    public function getItem(int $itemId): Item
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . $this->dbItem . " WHERE item_id = ?");
        $stmt->execute([$itemId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


        return Item::fromDatabaseRow($row);
    }
}