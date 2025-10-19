
let lastTab = 'inventory';
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

function switchBagTab(tab) {
    // TODO: resetar o scroll 
    lastTab = tab;
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

    window.scrollTo({ top: 0, behavior: 'auto' });
}

async function showUnequipConfirmation(slotName) {
    showConfirmationModal(
        'Unequip item?',
        async () => {
            await apiRequest('api/api_equipment', { action: 'removeEquipment', slotName: slotName });
            await fetchContent('pages/bag', '.conteudo-principal', { tab: 'equipment' });
        },
        () => { }
    );
}

async function equipItem(inventoryId) {
    await apiRequest('api/api_equipment', { action: 'equipItem', inventoryId: inventoryId });
    await fetchContent('pages/bag', '.conteudo-principal', { tab: 'equipment' });
    closeSelectEquipmentwindow();
}

document.addEventListener('DOMContentLoaded', function () {
    const selectEquipmentWindow = document.getElementById('select-equipment-window');

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openSelectEquipmentWindow = async function (equipmentType) {
        if (!selectEquipmentWindow) return;

        try {
            // Usa fetchContent global
            await fetchFunc('pages/select_equipment_window', '#select-equipment-window-content', { equipmentType: equipmentType });

            // Reset modal scroll
            const modalContent = selectEquipmentWindow.querySelector('#select-equipment-window-content');
            if (modalContent) {
                modalContent.scrollTop = 0; // reseta o scroll do conteúdo
            }

            selectEquipmentWindow.classList.add('active');
            // Ajuste do Scroll do Body
            const scrollY = window.scrollY;
            document.body.style.position = 'fixed';
            document.body.style.top = `-${scrollY}px`;
        } catch (error) {
            console.error("Erro ao abrir a janela do SelectEquipment:", error);
        }
    };

    window.closeSelectEquipmentwindow = function () {
        if (selectEquipmentWindow) {
            selectEquipmentWindow.classList.remove('active');

            // Ajuste do Scroll do Body
            const scrollY = Math.abs(parseInt(document.body.style.top || '0'));
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        }
    }

    // Fecha ao clicar no overlay
    if (selectEquipmentWindow) {
        selectEquipmentWindow.addEventListener('click', function (event) {
            if (event.target === selectEquipmentWindow) closeSelectEquipmentwindow();

            // Fecha se clicou no botão close, mesmo que ele seja carregado dinamicamente
            if (event.target.closest('#modal-close-btn')) closeSelectEquipmentwindow();
        });
    }

    // Fecha com ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && selectEquipmentWindow.classList.contains('active')) {
            closeSelectEquipmentwindow();
        }
    });
});
