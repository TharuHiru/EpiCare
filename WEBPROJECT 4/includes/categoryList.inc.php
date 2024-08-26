<!--add categories into the list box-->
<?php
// Database connection
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

// get categories from the database
$sql = "SELECT category FROM category";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    // Store fetched categories in an array
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
}

// Close the connection
$conn->close();
?>
