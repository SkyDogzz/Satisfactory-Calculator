<h1>Home</h1>
<script>
    async function getProductionSteps(targetItem) {
        const response = await fetch('public/contents/satisfactory/items.json');
        const data = await response.json();
        
        function createList(itemName, quantityNeeded) {
            const item = data.item.find(i => i.name === itemName);
            if (item && item.recipe && item.recipe.ingredients.length > 0) {
                const ul = document.createElement('ul');
                for (const ingredient of item.recipe.ingredients) {
                    const li = document.createElement('li');
                    li.textContent = `${ingredient.item} (Crafted: ${ingredient.quantity * quantityNeeded})`;
                    li.appendChild(createList(ingredient.item, ingredient.quantity * quantityNeeded));  // Recursively create lists
                    ul.appendChild(li);
                }
                return ul;
            }
            return document.createElement('ul');  // Return an empty list if there are no ingredients
        }
        
        const contentDiv = document.getElementById('content');
        const topLevelList = document.createElement('ul');
        const topLevelItem = document.createElement('li');
        topLevelItem.textContent = `${targetItem} (Crafted: 1)`;
        topLevelItem.appendChild(createList(targetItem, 1));
        topLevelList.appendChild(topLevelItem);
        contentDiv.appendChild(topLevelList);
    }
    
    getProductionSteps('Reinforced Iron Plate');
</script>
<div id="content"></div>
