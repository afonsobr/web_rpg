<?php
namespace TamersNetwork\Model;

use TamersNetwork\Repository\InventoryRepository;

class Inventory
{
    /** @var InventorySlot[] */
    private array $items = [];
    public function __construct(
        public readonly int $accountId,
        public InventoryRepository $repository,
    ) {
    }

    // Carrega o inventário do banco de dados
    public function load(): void
    {
        $this->items = $this->repository->getInventoryByAccountId($this->accountId);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
?>