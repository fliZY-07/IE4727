<?php

$db = new mysqli('localhost', 'root', '', 'myStyleLoft');
if (mysqli_connect_errno()) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}

// Check if the form was submitted
if (isset($_POST['orderId']) && isset($_POST['status'])) {
    // Retrieve data from the form submission
    $orderId = $_POST['orderId'];
    $status = $_POST['status'];

    // Update the order status in the database
    $sql = "UPDATE orders SET orderStatus = ? WHERE orderId = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("si", $status, $orderId);

    if ($stmt->execute()) {
        echo "Order status updated successfully!";
    } else {
        echo "Failed to update order status.";
    }
    
    // Redirect back to the original page
    header("Location: orderManagement.php"); // Replace 'ordersPage.php' with your actual page
    $stmt->close();
    $db->close();
    exit();
}