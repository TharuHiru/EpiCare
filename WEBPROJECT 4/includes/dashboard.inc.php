<?php
if (session_status() === PHP_SESSION_NONE ) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location: Adminlogin.php");
    exit();
}

// Prevent browser caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
