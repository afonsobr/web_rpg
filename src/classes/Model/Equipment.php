<?php
namespace TamersNetwork\Model;

use TamersNetwork\Repository\EquipmentRepository; // Usando o novo repositório

class Equipment
{
    // Propriedades públicas para fácil acesso, tipadas como Item ou null
    public ?InventorySlot $hat = null;
    public ?InventorySlot $headset = null;
    public ?InventorySlot $glasses = null;
    public ?InventorySlot $hands = null;
    public ?InventorySlot $jacket = null;
    public ?InventorySlot $upperBody = null; // Renomeado para snake_case como no BD
    public ?InventorySlot $lowerBody = null; // Renomeado para snake_case como no BD
    public ?InventorySlot $boots = null;
    public ?InventorySlot $ring = null; // Poderia ser ring_1, ring_2 se tiver múltiplos
    public ?InventorySlot $bracelet = null;
    public ?InventorySlot $gem = null;
    public ?InventorySlot $backpack = null;
    public ?InventorySlot $digivice = null;
    public ?InventorySlot $chipset = null;
    public ?InventorySlot $aura = null;

    // Slots disponíveis (poderia vir de uma config ou constante)
    private const AVAILABLE_SLOTS_MAP = [
        'hat' => 'hat',
        'headset' => 'headset',
        'glasses' => 'glasses',
        'hands' => 'hands',
        'jacket' => 'jacket',
        'upper_body' => 'upperBody', // Mapeia snake_case do BD para camelCase da propriedade
        'lower_body' => 'lowerBody', // Mapeia snake_case do BD para camelCase da propriedade
        'boots' => 'boots',
        'ring' => 'ring',
        'bracelet' => 'bracelet',
        'gem' => 'gem',
        'backpack' => 'backpack',
        'digivice' => 'digivice',
        'chipset' => 'chipset',
        'aura' => 'aura'
    ];

    public function __construct(
        int $accountId, // Recebe apenas o ID da conta
        EquipmentRepository $repository // Recebe o repositório dedicado
    ) {
        $this->loadEquippedItems($accountId, $repository);
    }

    /**
     * Carrega os itens equipados usando o repositório.
     */
    private function loadEquippedItems(int $accountId, EquipmentRepository $repository): void
    {
        // O repositório agora retorna um array como ['slot_name_bd' => ItemObject]
        $equippedItemsData = $repository->findByAccountId($accountId);

        foreach ($equippedItemsData as $dbSlotName => $item) {
            // Verifica se o nome do slot do BD existe no nosso mapa
            if (isset(self::AVAILABLE_SLOTS_MAP[$dbSlotName])) {
                // Pega o nome da propriedade correspondente em camelCase
                $propertyName = self::AVAILABLE_SLOTS_MAP[$dbSlotName];
                // Verifica se a propriedade existe na classe (segurança extra)
                if (property_exists($this, $propertyName)) {
                    $this->$propertyName = $item;
                }
            }
            // else { error_log("Slot desconhecido '{$dbSlotName}' ..."); }
        }
    }

    /**
     * Exemplo: Método para obter todos os itens equipados como array.
     * @return array<string, ?Item>
     */
    public function getAllEquippedItems(): array
    {
        $items = [];
        foreach (self::AVAILABLE_SLOTS_MAP as $propertyName) {
            if (property_exists($this, $propertyName)) {
                $items[$propertyName] = $this->$propertyName;
            }
        }
        return $items;
    }

    /**
     * Exemplo: Método para calcular um bônus total (ex: defesa).
     * (Assumindo que a classe Item tenha um método/propriedade para bônus)
     *
     * @return int
     */
    public function getTotalDefenseBonus(): int
    {
        $totalBonus = 0;
        foreach (self::AVAILABLE_SLOTS_MAP as $propertyName) {
            if (property_exists($this, $propertyName) && $this->$propertyName !== null) {
                // Supondo que Item tenha 'defenseBonus'
                if (isset($this->$propertyName->defenseBonus)) {
                    $totalBonus += $this->$propertyName->defenseBonus;
                }
            }
        }
        return $totalBonus;
    }

    public static function getSlotsMap(): array
    {
        return self::AVAILABLE_SLOTS_MAP;
    }

    /**
     * Retorna o nome da propriedade da classe (camelCase)
     * correspondente ao nome do slot no banco de dados (snake_case).
     *
     * @param string $dbSlotName O nome do slot como no banco de dados (ex: 'upper_body').
     * @return string|null O nome da propriedade (ex: 'upperBody') ou null se não encontrado.
     */
    public static function getPropertyNameForDbSlot(string $dbSlotName): ?string
    {
        return self::AVAILABLE_SLOTS_MAP[$dbSlotName] ?? null;
    }
}
?>