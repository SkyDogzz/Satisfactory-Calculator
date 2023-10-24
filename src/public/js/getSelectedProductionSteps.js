import getProductionSteps from './getProductionSteps.js';

export default async function getSelectedProductionSteps() {
    try {
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
    } catch (error) {
        console.error('There was an error in getSelectedProductionSteps:', error.message);
        // Optionally, display an error message to the user
        document.getElementById('content').innerText = 'An error occurred. Please try again.';
    }
}