const deleteBtn = document.getElementById("delete");
deleteBtn.addEventListener("click", () => {
    const productIdElement = document.getElementById("productId");
    
    // Ensure productId exists and is a valid integer
    if (productIdElement) {
        const productId = parseInt(productIdElement.innerText);

        // Check if productId is valid
        if (!isNaN(productId)) {
            fetch("./deleteProducts.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json' // Specify the content type
                },
                body: JSON.stringify({ productId: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Product deleted successfully:', data);
                    location.reload();
                    // Optionally, you can add logic here to update the UI or notify the user
                } else {
                    console.error('Error deleting product:', data.message);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
        } else {
            console.error('Invalid product ID.');
        }
    } else {
        console.error('Product ID element not found.');
    }
});
