function incrementNumber() {
    var currentNumber = parseInt(document.getElementById('quantity').value);

    var newNumber = currentNumber + 1;
    document.getElementById('quantity').value = newNumber;
  }

  function decrementNumber() {
    var currentNumber = parseInt(document.getElementById('quantity').value);
    if (currentNumber > 1) {
    var newNumber = currentNumber - 1;
    document.getElementById('quantity').value = newNumber;
    }
  }


  function addItem(itemId) {
    console.log(`updateItemQuantity called with itemId=${itemId}`);
    let quantityInput = document.getElementById('quantity');
    let quantity = parseInt(quantityInput.value);

    fetch(`/cart/item/${itemId}/add`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                item_id : itemId,
                quantity: quantity
            })
        })
        .then(response => {
            if (response.ok) {
                $('#successModal').modal('show');
            } else {
                $('#errorModal').modal('show');
                console.error('Failed to update item quantity');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
