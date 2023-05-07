async function shipItem(orderId) {
    const response = await fetch(`/admin/orders/${orderId}/ship`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    });

    const data = await response.json();
    if (data.success) {
        alert('Order marked as shipped');
        location.reload();
    } else {
        alert('An error occurred');
    }
}

async function markAsPaid(orderId) {
    const response = await fetch(`/admin/orders/${orderId}/pay`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    });

    const data = await response.json();
    if (data.success) {
        alert('Order marked as paid');
        location.reload();
    } else {
        alert('An error occurred');
    }
}
