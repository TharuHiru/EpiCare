<?php
if (isset($_POST["submit"])) {
    // Database configuration
$host = 'epicare.mysql.database.azure.com';
$port = 3306;
$username = 'EpiAdmin';
$password = 'WebAdEp12';
$dbname = 'epicare_skincare';

// Path to your SSL certificate
$ssl_ca = '/home/site/wwwroot/certs/ca-cert.pem'; // Ensure this path is correct

// Create connection with SSL
$conn = new mysqli();
$conn->ssl_set(null, null, $ssl_ca, null, null);
$conn->real_connect($host, $username, $password, $dbname, $port, null, MYSQLI_CLIENT_SSL);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit();
}

if (isset($_GET['sell_ID'])) {
    $id = $_GET['sell_ID'];

    // Prepare the delete query
    $sql = "DELETE FROM selling WHERE sell_ID=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        // Redirect to the same page after deletion
        header("Location: ../Inventory Tracking.php?delete=success");
    } else {
        // Handle SQL error
        header("Location: ../Inventory Tracking.php?delete=error");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location: ../Inventory Tracking.php?delete=error");
}
?>
