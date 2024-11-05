<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productsToRemove = $_POST['products'];

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    if (mysqli_connect_errno()) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not connect to the database. Please try again later.']);
        exit;
    }

    // Prepare the SQL statement
    $query = "DELETE FROM shoppingCart WHERE productId = ?";
    $stmt = $db->prepare($query);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not prepare statement. Please try again later.']);
        exit;
    }

    $anyRemoved = false; // Flag to track if any product was removed

    // Loop through the products to remove
    foreach ($productsToRemove as $productId) {
        // Bind the product ID
        $stmt->bind_param('i', $productId);
        
        // Execute the statement
        $success = $stmt->execute();

        if ($success) {
            $anyRemoved = true; // Set flag to true if at least one product was removed
        }
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();

    // Prepare the response based on the removal outcome
    header('Content-Type: application/json');
    if ($anyRemoved) {
        echo json_encode(['success' => true, 'message' => 'Products removed successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No products were removed.']);
    }
}

