document.addEventListener('DOMContentLoaded', () => {

        function toggleFilter() {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        let maxStock = 0;
    
        // Toggle Filter Dropdown Visibility
        document.querySelector('.filter-button')?.addEventListener('click', () => {
            const dropdown = document.getElementById('filterDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
    
        // Open Cart Popup
        window.openCartPopup = (picture, price, stock) => {
            const popup = document.getElementById('cartPopup');
            if (!popup) return;
    
            document.getElementById('popupItemImage').src = picture;
            document.getElementById('popupItemPrice').innerText = 'Rp' + Number(price).toLocaleString('id-ID');
            document.getElementById('popupItemStock').innerText = 'Stock: ' + stock;
            document.getElementById('quantityInput').value = 1;
    
            maxStock = parseInt(stock);
            popup.style.display = 'flex';
        };
    
        // Close Cart Popup
        window.closeCartPopup = () => {
            const popup = document.getElementById('cartPopup');
            if (popup) popup.style.display = 'none';
        };
    
        // Decrease Quantity
        window.decreaseQuantity = () => {
            const quantityInput = document.getElementById('quantityInput');
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
            }
        };
    
        // Increase Quantity
        window.increaseQuantity = () => {
            const quantityInput = document.getElementById('quantityInput');
            let quantity = parseInt(quantityInput.value);
            if (quantity < maxStock) {
                quantityInput.value = quantity + 1;
            }
        };
    
        // Add to Cart (Placeholder Functionality)
        window.addToCart = () => {
            const quantity = document.getElementById('quantityInput').value;
            alert(`Item added to cart with quantity: ${quantity}`);
            closeCartPopup();
        };

        const url = new URL(window.location.href);

        if (url.searchParams.has('search') || url.searchParams.has('category[]')) {
            // Wait for the page to load, then remove search parameters
            window.history.replaceState({}, document.title, '/product');
        }
        
    });
    