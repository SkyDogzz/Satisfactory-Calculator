import fetchItems from './fetchItems.js';

export default async function getProductionSteps(targetItem, quantity) {
    try {
        const data = await fetchItems();

        function createList(itemName, quantityNeeded) {
            const item = data.item.find(i => i.name === itemName);
            if (item && item.recipe && item.recipe.ingredients.length > 0) {
                const ul = document.createElement('ul');
                const outputQuantityPerRecipe = item.recipe.output.quantity;
                // Calculating the number of recipes required
                const recipesRequired = Math.ceil(quantityNeeded / outputQuantityPerRecipe);
                for (const ingredient of item.recipe.ingredients) {
                    const li = document.createElement('li');
                    // Adjusting the ingredient quantity based on the number of recipes required
                    const ingredientQuantity = ingredient.quantity * recipesRequired;
                    li.textContent = `${ingredientQuantity} ${ingredient.item}`;
                    li.appendChild(createList(ingredient.item, ingredientQuantity));  // Recursively create lists
                    ul.appendChild(li);
                }
                return ul;
            }
            return document.createElement('ul');  // Return an empty list if there are no ingredients
        }

        const contentDiv = document.getElementById('content');
        const topLevelList = document.createElement('ul');
        const topLevelItem = document.createElement('li');
        topLevelItem.textContent = `${quantity} ${targetItem}`;
        topLevelItem.appendChild(createList(targetItem, quantity));  // Pass the quantity here
        topLevelList.appendChild(topLevelItem);
        contentDiv.appendChild(topLevelList);
    } catch (error) {
        console.error('There was an error in getProductionSteps:', error.message);
        // Optionally, display an error message to the user
        document.getElementById('content').innerText = 'An error occurred. Please try again.';
    }
}
