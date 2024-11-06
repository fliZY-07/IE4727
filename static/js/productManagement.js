const deleteBtns = document.querySelectorAll(".delete");
deleteBtns.forEach(deleteBtn => {
    deleteBtn.addEventListener("click", () => {
        const productId = parseInt(deleteBtn.getAttribute("data-productId"));
        console.log(productId);
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
    });
})