document.addEventListener('DOMContentLoaded', () => {
    // Toggle Filter Dropdown
    window.toggleFilter = () => {
        const dropdown = document.getElementById('filterDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    };

    // Remove Search and Filter Parameters from URL After Submission
    const url = new URL(window.location.href);
    if (url.searchParams.has('search') || url.searchParams.has('category[]')) {
        window.history.replaceState({}, document.title, '/product');
    }
});
