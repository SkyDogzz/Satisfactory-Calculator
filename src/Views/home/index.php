<h1>Home</h1>



<script>
    async function getProductionSteps(targetItem) {
        const response = await fetch('public/contents/satisfactory/items.json');
        const data = await response.json();
        
        const steps = [];
        
        async function findIngredients(itemName) {
            const item = data.item.find(i => i.name === itemName);
            if (item && item.recipe && item.recipe.ingredients.length > 0) {
                for (const ingredient of item.recipe.ingredients) {
                    steps.push({
                        output: item.name,
                        input: ingredient.item,
                        quantity: ingredient.quantity,
                        machine: item.recipe.machine
                    });
                    await findIngredients(ingredient.item);  // Recursively find ingredients
                }
            }
        }
        
        await findIngredients(targetItem);
        
        return steps;
    }
    
    getProductionSteps('Reinforced Iron Plate').then(steps => {
        console.log(steps);
    });
</script>