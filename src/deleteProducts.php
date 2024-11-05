<?php

$json = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($json, true); // Convert JSON to associative array

// Check if productId is present in the request
if (isset($data['productId'])) {
    $productId = $data['productId'];

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    // Check connection
    if (mysqli_connect_errno()) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not connect to the database.']);
        exit;
    }

    // Prepare the statement
    $stmt = $db->prepare("DELETE FROM products WHERE productId = ?");
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not prepare statement.']);
        exit;
    }

    // Bind the parameter and execute
    $stmt->bind_param("i", $productId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: Could not delete product.']);
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error: productId not provided.']);
}
