import getProductionSteps from './getProductionSteps.js';

export default async function getSelectedProductionSteps() {
    try {
        const contentDiv = document.getElementById('content');
        contentDiv.innerHTML = '';
        const craftItems = document.querySelectorAll('.craft-item');
        
        for (const craftItem of craftItems) {
            const selectElement = craftItem.querySelector('.item-select');
            const selectedItem = selectElement.value;
            const quantityInput = craftItem.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value, 10);
            
            if (selectedItem && quantity > 0) {
                await getProductionSteps(selectedItem, quantity);
            }
        }
    } catch (error) {
        console.error('There was an error in getSelectedProductionSteps:', error.message);
        // Optionally, display an error message to the user
        document.getElementById('content').innerText = 'An error occurred. Please try again.';
    }
}
