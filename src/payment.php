<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";

include("./utils/loginStatus.php");

// Connect to the database
$db = new mysqli('localhost', 'root', '', 'myStyleLoft');

if ($db->connect_errno) {
    echo "Error: Could not connect to the database. Please try again later.";
    exit;
}

// Fetch user ID
$customerId = $_SESSION['customerId'];
$orderStatus = "Paid";

$totalPrice = (float)(preg_replace('/[^\d.]/', '', $_POST['totalPrice']));

// Corrected SQL statement with VALUES
$query = $db->prepare('INSERT INTO orders (orderStatus, total, customerId) VALUES (?, ?, ?)');
$query->bind_param('ssi', $orderStatus, $totalPrice, $customerId);

// Execute and check for errors
if (!$query->execute()) {
    echo "Error inserting order: " . $query->error;
    exit;
}

// Get the last inserted order ID
$orderId = $db->insert_id;

// Prepare the statement for ordered items
$stmt = $db->prepare('INSERT INTO orderedItems (productSize, quantity, subTotal, orderId, productId) VALUES (?, ?, ?, ?, ?)');

$productNames = $_POST['productName'];
$quantities = $_POST['quantity'];
$sizes = $_POST['size'];
$subtotals = $_POST['subtotals'];
$productIds = $_POST['productIds'];

// Insert ordered items in a loop
for ($i = 0; $i < sizeof($productIds); $i++) {
    $stmt->bind_param('siidi', $sizes[$i], $quantities[$i], $subtotals[$i], $orderId, $productIds[$i]);

    if (!$stmt->execute()) {
        echo "Error inserting ordered item: " . $stmt->error;
        exit;
    }
}

// Prepare and execute the DELETE statement to remove items from the cart
$deleteStmt = $db->prepare('DELETE FROM shoppingCart WHERE productId = ? AND customerId = ?');

foreach ($productIds as $productId) {
    $deleteStmt->bind_param('ii', $productId, $customerId);
    
    if (!$deleteStmt->execute()) {
        echo "Error deleting item from cart: " . $deleteStmt->error;
        exit;
    }
}

// Close the statements
$query->close();
$stmt->close();
$deleteStmt->close();
$db->close();

// Redirect to order tracking after all inserts
header('Location: orderTracking.php');
exit;
