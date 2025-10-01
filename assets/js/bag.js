// assets/js/bag.js

/**
 * Filtra a lista de itens do inventário.
 * Esta função é chamada pelo listener de eventos global em game.php.
 */
function filterInventory() {
    const input = document.getElementById('inventory-search-input');
    if (!input) return; // Se o input não está na página, não faz nada.

    const searchTerm = input.value.toLowerCase().trim();
    const items = document.querySelectorAll('#inventory-list-container .inventory-item');

    items.forEach(item => {
        const itemNameElement = item.querySelector('.item-name');
        if (itemNameElement) {
            const itemName = itemNameElement.textContent.toLowerCase().trim();
            if (itemName.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

function switchTab(tab) {
    const inventory = document.getElementById('bag-inventory');
    const equipment = document.getElementById('bag-equipment');

    const inventoryBtn = document.getElementById('header-menu-inventory');
    const equipmentBtn = document.getElementById('header-menu-equipment');

    inventoryBtn.classList.remove("active");
    equipmentBtn.classList.remove("active");
    if (tab === 'inventory') {
        inventory.hidden = false;
        equipment.hidden = true;
        inventoryBtn.classList.add("active");

    } else if (tab === 'equipment') {
        inventory.hidden = true;
        equipment.hidden = false;
        equipmentBtn.classList.add("active");

    }
}