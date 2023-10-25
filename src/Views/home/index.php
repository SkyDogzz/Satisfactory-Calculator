<h1>Home</h1>

<div id="craft-container">
    <div class="craft-item">
        <select class="item-select">
            <option value="" disabled selected>Select an item</option>
            <!-- Les options seront remplis par JavaScript -->
        </select>
        <input type="number" class="quantity-input" value="1" min="1">
    </div>
</div>

<button id="add-craft-button">Ajouter Craft</button>
<button id="remove-craft-button">Supprimer Craft</button>

<div id="content"></div>

<script type="module">
    // main.js
import fetchItems from '/public/js/fetchItems.js';
import getSelectedProductionSteps from '/public/js/getSelectedProductionSteps.js';

document.getElementById('add-craft-button').onclick = addCraft;
document.getElementById('remove-craft-button').onclick = removeCraft;

async function initialize() {
    const data = await fetchItems();
    populateSelects(data);
}

function populateSelects(data) {
    document.querySelectorAll('.item-select').forEach(selectElement => {
        data.item.forEach(item => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
    });
}

function addCraft() {
    const craftContainer = document.getElementById('craft-container');
    const newCraftItem = document.querySelector('.craft-item').cloneNode(true);
    newCraftItem.querySelector('.quantity-input').value = '1';
    craftContainer.appendChild(newCraftItem);
}

function removeCraft() {
    const craftContainer = document.getElementById('craft-container');
    if (craftContainer.children.length > 1) {
        craftContainer.removeChild(craftContainer.lastChild);
    }
}

initialize();

document.getElementById('craft-container').oninput = getSelectedProductionSteps;

</script>
