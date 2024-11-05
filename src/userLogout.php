<?php
session_start(); // Start the session

function logout(): void {
    if (isset($_SESSION['customerId'])) {
        unset($_SESSION['customerId']);
    }

    header("Location: userLogin.php"); // Redirect to login page
    exit();
}

logout();