export default async function fetchItems() {
    try {
        const response = await fetch('public/contents/satisfactory/items.json');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}
