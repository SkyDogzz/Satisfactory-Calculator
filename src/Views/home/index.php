<h1>Home</h1>
<select id="item-select" onchange="getSelectedProductionSteps()">
    <option value="" disabled selected>Select an item</option>
    <!-- Les options seront remplis par JavaScript -->
</select>

<div id="content"></div>

<script>
    async function fetchItems() {
        const response = await fetch('public/contents/satisfactory/items.json');
        return response.json();
    }

    fetchItems().then(data => {
        const selectElement = document.getElementById('item-select');
        data.item.forEach(item => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
    });

    async function getSelectedProductionSteps() {
        const contentDiv = document.getElementById('content');
        contentDiv.innerHTML = ''; 
        const selectElement = document.getElementById('item-select');
        const selectedItem = selectElement.value;
        if (selectedItem) {
            console.log(selectedItem);
            await getProductionSteps(selectedItem);
        }
    }

    async function getProductionSteps(targetItem) {
        const data = await fetchItems();
        const response = await fetch('public/contents/satisfactory/items.json');

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

    // Si vous souhaitez charger les étapes de production pour un item par défaut au chargement de la page :
    // window.onload = () => getProductionSteps('Reinforced Iron Plate');
</script>