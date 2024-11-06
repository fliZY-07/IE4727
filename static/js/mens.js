const checkboxes = document.querySelectorAll('input[name="category"]');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', applyFilters);
});

                
function applyFilters() {
    const formData = new FormData(); // Create a new FormData object
    const checkboxes = document.querySelectorAll('input[name="category"]:checked'); // Select all checked category checkboxes
    
    // Append checked category values to FormData
    checkboxes.forEach(cb => formData.append('categories[]', cb.value));
    // Convert FormData to a plain object for easier logging
    const categories = [];
    for (const value of formData.getAll('categories[]')) {
        categories.push(value);
    }

    fetch('./filter.php', {
        method: 'POST',
        body: JSON.stringify({ categories: categories , gender: 'Men'}),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('products').innerHTML = data; // Update with the complete HTML
    })
    .catch(error => console.error('Error:', error));
}

function openForm(element) {
    // Get product details from data attributes
    const productImage = element.getAttribute('data-productImage');
    const productName = element.getAttribute('data-productName');
    const productDescription = element.getAttribute('data-description');
    const productPrice = element.getAttribute('data-price');
    const productId = element.getAttribute('data-productId');


    // Populate popup content
    document.getElementById('popupImage').src = productImage;
    document.getElementById('popupName').textContent = productName;
    document.getElementById('popupDescrip').textContent = productDescription;
    document.getElementById('popupPrice').textContent = '$' + productPrice;
    document.getElementById('popupProductId').value = productId;

    // Show the popup
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    // Hide the popup
    document.getElementById("myForm").style.display = "none";
}