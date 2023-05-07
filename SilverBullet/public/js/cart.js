function decreaseQuantity(itemId) {
    updateItemQuantity(itemId, -1);
}

function increaseQuantity(itemId) {
    updateItemQuantity(itemId, 1);
}

function updateQuantity(itemId) {
    let quantityInput = document.getElementById('quantity' + itemId);
    let newQuantity = parseInt(quantityInput.value);
    updateItemQuantity(itemId, newQuantity, true);
}

function removeItem(itemId) {
    fetch(`/cart/item/${itemId}/remove`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                console.error('Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function updateItemQuantity(itemId, delta, absolute = false) {
    console.log(`updateItemQuantity called with itemId=${itemId}, delta=${delta}, absolute=${absolute}`);
    let quantityInput = document.getElementById('quantity' + itemId);
    let currentQuantity = parseInt(quantityInput.value);
    let newQuantity = absolute ? delta : currentQuantity + delta;

    if (newQuantity < 1) {
        newQuantity = 1;
    }

    fetch(`/cart/item/${itemId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                quantity: newQuantity
            })
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                console.error('Failed to update item quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
