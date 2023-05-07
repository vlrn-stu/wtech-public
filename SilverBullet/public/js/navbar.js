window.addEventListener('DOMContentLoaded', async () => {
    const response = await fetch('/categories');
    const data = await response.json();
    const categories = data.categories;
    const categoryDropdown = document.getElementById('category-dropdown');

    categories.forEach(category => {
        const listItem = document.createElement('li');
        const button = document.createElement('button');

        button.classList.add('dropdown-item');
        button.type = 'button';
        button.textContent = category.name;

        button.onclick = () => {
            window.location.href = `/search?search_query=${category.name}`;
        };

        listItem.appendChild(button);
        categoryDropdown.appendChild(listItem);
    });
});
