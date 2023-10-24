<h1>Home</h1>
<select id="item-select">
    <option value="" disabled selected>Select an item</option>
    <!-- Les options seront remplis par JavaScript -->
</select>

<input type="number" id="quantity-input" value="1" min="1">

<div id="content"></div>

<script type="module">
    import fetchItems from '/public/js/fetchItems.js';
    import getSelectedProductionSteps from '/public/js/getSelectedProductionSteps.js';
    import getProductionSteps from '/public/js/getProductionSteps.js';
    
    fetchItems().then(data => {
        const selectElement = document.getElementById('item-select');
        data.item.forEach(item => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
    });

    document.getElementById('item-select').onchange = getSelectedProductionSteps;
    document.getElementById('quantity-input').oninput = getSelectedProductionSteps;
</script>
