import fetchItems from './fetchItems.js';

function appendItemList(data) {
    const ul = document.createElement('ul');
    data.forEach(item => {
        const li = document.createElement('li');
        li.textContent = item.quantity + ' ' + item.name;
        ul.appendChild(li);
    });
    return ul;
}


export default async function getProductionSteps(targetItem, quantity) {
    try {
        let all = []
        const data = await fetchItems();

        function createList(itemName, quantityNeeded) {
            const item = data.item.find(i => i.name === itemName);
            if (item && item.recipe && item.recipe.ingredients.length > 0) {
                const ul = document.createElement('ul');
                let outputQuantityPerRecipe = 0;
                if (item.recipe.outputs.length > 1) {
                    for (let i = 0; i < item.recipe.outputs.length; i++) {
                        if (item.recipe.outputs[i].item === item.name) {
                            outputQuantityPerRecipe = item.recipe.outputs[i].quantity;
                        }
                    }
                }
                else {
                    outputQuantityPerRecipe = item.recipe.outputs[0].quantity;
                }

                // Calculating the number of recipes required
                const recipesRequired = quantityNeeded / outputQuantityPerRecipe;  // Changed from Math.ceil to simple division

                for (const ingredient of item.recipe.ingredients) {
                    const li = document.createElement('li');

                    // Adjusting the ingredient quantity based on the number of recipes required
                    const ingredientQuantity = ingredient.quantity * recipesRequired;

                    // Format the number to 2 decimal places if it's not a whole number
                    const formattedQuantity = (ingredientQuantity % 1 === 0) ? ingredientQuantity : ingredientQuantity.toFixed(2);

                    let added = false;
                    all.forEach(item => {
                        if (item.name === ingredient.item) {
                            item.quantity += ingredientQuantity
                            added = true
                        }
                    })
                    if (!added) {
                        all.push({
                            name: ingredient.item,
                            quantity: ingredientQuantity
                        })
                    }

                    li.textContent = `${formattedQuantity} ${ingredient.item}`;
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

        // append the item list
        const itemList = appendItemList(all);
        contentDiv.appendChild(itemList);
    } catch (error) {
        console.error('There was an error in getProductionSteps:', error.message);
        // Optionally, display an error message to the user
        document.getElementById('content').innerText = 'An error occurred. Please try again.';
    }
}
