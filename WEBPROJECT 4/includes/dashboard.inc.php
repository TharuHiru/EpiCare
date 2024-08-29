<?php
// Start output buffering to prevent headers already sent errors
ob_start();

// Start the session if it hasn't started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in by checking the session variable
if (!isset($_SESSION['userId'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: Adminlogin.php");
    exit();
}

// Prevent browser caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Flush the output buffer and send the headers
ob_end_flush();
?>
