document.addEventListener('DOMContentLoaded', () => {
    window.toggleFilter = () => {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    };

    const url = new URL(window.location.href);
    if (url.searchParams.has('search') || url.searchParams.has('category[]')) {
        window.history.replaceState({}, document.title, '/product');
    }
});
