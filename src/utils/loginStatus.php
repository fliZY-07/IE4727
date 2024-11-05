<?php
session_start(); // Start the session

// Function to check if user is logged in
function checkUserLoggedIn() {
    if (!isset($_SESSION['customerId'])) { // Check if 'customerId' session variable is set
        header("Location: userLogin.php"); // Redirect to login page
        exit; // Stop script execution after redirection
    }
}

checkUserLoggedIn();