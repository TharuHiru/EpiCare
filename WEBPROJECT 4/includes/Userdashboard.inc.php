<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: Userlogin.php");
    exit();
}

// Prevent browser caching of this page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

include 'includes/dbh.inc.php';

// Fetch user status from the database
$user_id = $_SESSION['userId'];
$sql = "SELECT status FROM users WHERE user_id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $status);
    mysqli_stmt_fetch($stmt);

    // Check if the user's status is deactivated
    if ($status === 'deactivated') {
        session_destroy();  // End the session
        header("Location: Userlogin.php?status=deactivated");
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Handle SQL error
    echo "Error fetching user status.";
    exit();
}
?>
