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
// SQL query to fetch item details along with category name and image path, with Total_inventory calculated
$sql = "SELECT items.item_ID, items.item_name, items.quantity, items.buying_price, items.selling_price, 
               total_inventory,items.image_path, category.category, items.description
        FROM items
        JOIN category ON items.categoryId = category.categoryId";
$result = mysqli_query($conn, $sql);

$items = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
}

mysqli_close($conn);

return $items;
?>
