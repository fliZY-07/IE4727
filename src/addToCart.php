<?php
include("./utils/loginStatus.php");

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection settings
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    // Check for connection errors
    if ($db->connect_errno) {
        echo "Error: Could not connect to the database. Please try again later.";
        exit;
    }

    // Verify if customer ID exists in session
    if (!isset($_SESSION['customerId'])) {
        echo "Error: User is not logged in.";
        exit;
    }

    // Sanitize and assign variables
    $customerId = intval($_SESSION['customerId']);
    $productSize = $db->real_escape_string($_POST['productSize']);
    $productId = intval($_POST['productId']);
    $quantity = intval($_POST['quantity']);

    // Prepare the SQL insert statement
    $query = "INSERT INTO shoppingCart (productSize, quantity, customerId, productId) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("siii", $productSize, $quantity, $customerId, $productId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Product added to cart successfully!";
            $referrer = basename($_SERVER['HTTP_REFERER']);  // Get the name of the referring page
    
            if ($referrer === 'womens.php') {
                header("Location: ./womens.php");
            } else {
                header("Location: ./mens.php");
            }
        } else {
            echo "Error: Could not add product to cart. Please try again.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare the statement.";
    }

    // Close the database connection
    $db->close();
}