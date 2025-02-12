document.addEventListener('DOMContentLoaded', () => {
    let itemIdToRemove = null;   // Tracks the item to be removed

    // Decrease Quantity Function
    window.decreaseQuantity = (itemId) => {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity === 1) {
            // Show confirmation popup if quantity is 1
            itemIdToRemove = itemId;
            document.getElementById('removeItemPopup').style.display = 'flex';
        } else {
            // Decrease quantity and update server
            updateQuantity(itemId, currentQuantity - 1);
        }
    };

    // Increase Quantity Function
    window.increaseQuantity = (itemId, maxStock) => {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity < maxStock) {
            updateQuantity(itemId, currentQuantity + 1);
        } else {
            alert('You cannot exceed the available stock.');
        }
    };

    // Function to Update Quantity on Server
    function updateQuantity(itemId, newQuantity) {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        quantityInput.value = newQuantity;

        fetch('/update-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ item_id: itemId, quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();  // Refresh to update totals and quantities
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    }

    // Confirm Removal When 'Yes' Button is Clicked
    window.confirmRemove = () => {
        if (itemIdToRemove) {
            fetch('/remove-from-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ item_id: itemIdToRemove })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();  // Reload the page to reflect the updated cart
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
            });

            closeRemovePopup();  // Close the popup after sending the request
        }
    };

    // Function to close the remove confirmation popup
    window.closeRemovePopup = () => {
        document.getElementById('removeItemPopup').style.display = 'none';
    };
});
