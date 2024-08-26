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

// Query to fetch all rows from the selling table
$sql = "SELECT sell_ID, user_Id, item_ID, quantity, Amount, Date FROM selling";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Close the connection
mysqli_close($conn);
?>
