<?php
namespace TamersNetwork\Model;

use TamersNetwork\Helper\Helper;
use TamersNetwork\Repository\InventoryRepository;

class Equipment
{
    public Item $hat;
    public Item $Headset;
    public function __construct(
        public Account $account,
        public InventoryRepository $repository,
    ) {
    }
}
?>