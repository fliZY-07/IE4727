<?php

$json = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($json, true); // Convert JSON to associative array

// Check if orderId is present in the request
if (isset($data['orderId'])) {
    $orderId = $data['orderId']; // Use the correct variable name

    // Connect to the database
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    // Check connection
    if ($db->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not connect to the database.']);
        exit;
    }

    // Prepare the statement
    $stmt = $db->prepare("UPDATE `orders` SET orderStatus = 'Received' WHERE orderId = ?");
    
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error: Could not prepare statement.']);
        exit;
    }

    // Bind the parameter and execute
    $stmt->bind_param("i", $orderId); // Correct binding to use $orderId
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Order received successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: Could not update order status.']);
    }

    // Close the statement and database connection
    $stmt->close();
    $db->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error: orderId not provided.']);
}