const quantity_inputs = document.querySelectorAll(".quantity_input");
const subtotals = document.querySelectorAll(".price");
const prices = document.querySelectorAll(".unit_price");

for (var i = 0; i < quantity_inputs.length; i++) {
    const quantity_input = quantity_inputs[i];
    const subtotal = subtotals[i];
    const price = prices[i];

    quantity_input.addEventListener("input", event => {
        subtotal.textContent = "$" + parseFloat(quantity_input.value) * parseFloat(price.textContent);
    })
}

function redirectToCheckout(event) {
    event.preventDefault();

    // Check if any items are selected
    const selectedItems = document.querySelectorAll('.itemCheckbox:checked');
    const form = document.getElementById("shoppingCart");

    if (selectedItems.length > 0) {
        // Redirect to the checkout page if items are selected
        form.submit();
    } else {
        alert("Please select at least one item to proceed to checkout.");
    }
}

const removeBtn = document.getElementById('removeFromCart');
removeBtn.addEventListener('click', () => {
    const selectedItems = document.querySelectorAll('.itemCheckbox:checked');
    var selectedProducts = [];
    if (selectedItems.length > 0) {
        selectedItems.forEach(selectedItem => {
            selectedProducts.push(selectedItem.value);
        });

        // Create a URLSearchParams object
        const params = new URLSearchParams();
        selectedProducts.forEach(product => {
            params.append('products[]', product); // Append each product to the params
        });

        fetch('./removeFromCart.php', {
            method: "POST",
            body: params
        })
        .then(response => response.json()) // Assuming your PHP returns JSON
        .then(data => {
            // Handle success or update the UI accordingly
            if (data.success) {
                alert("Items removed successfully!");
                location.reload(); // Reload the page or update the cart display
            } else {
                alert("Failed to remove items.");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while removing items.");
        });
    } else {
        alert("Please select at least one item to remove.");
    }
});