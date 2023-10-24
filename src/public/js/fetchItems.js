export default async function fetchItems() {
    const response = await fetch('public/contents/satisfactory/items.json');
    return response.json();
}
