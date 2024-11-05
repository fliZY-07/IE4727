const receiveBtn = document.getElementById('receive');

// Add an event listener for the "Receive" button
receiveBtn.addEventListener('click', () => {
    const orderId = document.getElementById("orderId").value; // Get the order ID from the input field

    // Check if orderId is valid before proceeding
    if (!orderId) {
        console.error("Order ID is required.");
        alert("Please enter a valid Order ID.");
        return; // Exit the function if orderId is not provided
    }

    console.log("Sending request to receive order with ID:", orderId);
    
    // Send the POST request to receiveOrder.php
    fetch("./receiveOrder.php", {
        method: "POST",
        body: JSON.stringify({ orderId: orderId }),
        headers: {
            'Content-Type': 'application/json' // Specify the content type
        }
    })
    .then(response => {
        // Check if the response is okay (status in the range 200-299)
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json(); // Parse the JSON from the response
    })
    .then(data => {
        console.log("Response data:", data);
        if (data.success) {
            alert("Order received successfully."); // Notify the user of success
        } else {
            alert("Error: " + data.message); // Show error message from the server
        }
        location.reload(); // Reload the page to reflect changes
    })
    .catch(error => {
        console.error("There was a problem with the fetch operation:", error);
        alert("An error occurred while processing your request. Please try again.");
    });
});