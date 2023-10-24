import getProductionSteps from './getProductionSteps.js';

export default async function getSelectedProductionSteps() {
    const contentDiv = document.getElementById('content');
    contentDiv.innerHTML = '';
    const selectElement = document.getElementById('item-select');
    const selectedItem = selectElement.value;
    const quantityInput = document.getElementById('quantity-input');
    const quantity = parseInt(quantityInput.value, 10);
    console.log(quantity);
    if (selectedItem && quantity > 0) {
        console.log(selectedItem);
        await getProductionSteps(selectedItem, quantity);
    }
}
