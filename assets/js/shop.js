// digimon.js
document.addEventListener('DOMContentLoaded', function () {

    window.itemQuantity = 0;
    window.itemPrice = 0;
    window.itemCost = 0;
    window.shop_itemIdToBuy = 0;

    // Certifica que fetchContent existe no window
    const fetchFunc = window.fetchContent;
    if (!fetchFunc) {
        console.error("fetchContent não encontrado! Certifique-se que foi definido antes.");
        return;
    }

    window.openShopItemWindow = async function (itemId) {
        window.shop_itemIdToBuy = itemId;
        await openCommonWindow('pages/buy_item_window', '#common-window-content', { itemId: itemId });

        const dataTag = document.querySelector('#buy-data');
        if (dataTag) {
            const data = JSON.parse(dataTag.textContent);

            // Atualiza variáveis
            window.itemQuantity = data.quantity;
            window.itemPrice = data.costEach;
            window.itemCost = data.costTotal;

            console.log('valores atualizados:', data);
        }
    }

    window.shopConfirm = async function () {

    }

    window.changeItemQuantity = function (qtd) {
        window.itemQuantity += qtd;
        if (window.itemQuantity < 1) {
            window.itemQuantity = 1;
        }
        else if (window.itemQuantity > 999) {
            window.itemQuantity = 999;
        }

        window.itemCost = window.itemQuantity * window.itemPrice;
        document.getElementById('qtd-value').innerText = window.itemQuantity;
        document.getElementById('total-value').innerText = window.itemCost;
    }

    window.buyItemQuantity = async function () {
        console.log(window.itemQuantity,
            window.itemPrice,
            window.itemCost,
            window.shop_itemIdToBuy);
        closeCommonWindow();
        showLoadingModal('Processing...');
        const result = await apiRequest('api/api_shop', { action: 'buyItem', itemId: shop_itemIdToBuy, itemQuantity: itemQuantity, itemPrice: itemPrice, itemCost: itemCost });
        await fetchFunc('includes/header_hud', '.cabecalho-sobreposto');

        // console.log(result);
        setTimeout(() => {
            hideLoadingModal();
            if (result['success'] == true) {
                showAlertModal(`<div><b>Purchase successful!</b></div>`);
            }
            else {
                showAlertModal(`<div><b>Purchase error:</b></div><br>${result.message}`);
            }
        }, 1000);
    }
});
