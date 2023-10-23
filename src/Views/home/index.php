<h1>Home</h1>



<script>
    async function getProductionSteps(targetItem) {
        const response = await fetch('public/contents/satisfactory/items.json');
        const data = await response.json();
        
        const steps = [];
        
        async function findIngredients(itemName, quantityNeeded) {
            const item = data.item.find(i => i.name === itemName);
            if (item && item.recipe && item.recipe.ingredients.length > 0) {
                const step = {
                    output: item.name,
                    ingredients: [],
                    machine: item.recipe.machine
                };
                for (const ingredient of item.recipe.ingredients) {
                    step.ingredients.push({
                        name: ingredient.item,
                        quantity: ingredient.quantity * quantityNeeded
                    });
                    await findIngredients(ingredient.item, ingredient.quantity * quantityNeeded);
                }
                steps.push(step);
            }
        }
        
        await findIngredients(targetItem, 1);
        
        return steps;
    }
    
    getProductionSteps('Reinforced Iron Plate').then(steps => {
        console.log(steps);
    });
</script>
