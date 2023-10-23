<h1>Home</h1>
<script>
    async function getProductionSteps(targetItem) {
        const response = await fetch('public/contents/satisfactory/items.json');
        const data = await response.json();
        
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
        topLevelItem.textContent = `1 ${targetItem}`;
        topLevelItem.appendChild(createList(targetItem, 1));
        topLevelList.appendChild(topLevelItem);
        contentDiv.appendChild(topLevelList);
    }
    
    getProductionSteps('Reinforced Iron Plate');
</script>
<div id="content"></div>
