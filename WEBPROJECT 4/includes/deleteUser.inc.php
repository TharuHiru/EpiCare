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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the update query to set status to "deactivated"
    $sql = "UPDATE users SET status=? WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        $status = "deactive";
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);

        // Redirect to the same page after updating the status
        header("Location:../User Management.php?statusupdate=success");
    } else {
        // Handle SQL error
        header("Location:../User Management.php?statusupdate=error");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location:../User Management.php?statusupdate=error");
}
?>
