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
$sql = "SELECT categoryId, category FROM category";
$result = mysqli_query($conn, $sql);

$tableRows = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tableRows .= '<tr>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['categoryId'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['category'] . '</td>';
        $tableRows .= '</tr>';
    }
} else {
    $tableRows = '<tr><td colspan="3" class="text-center">No categories found.</td></tr>';
}

mysqli_close($conn);

// Pass the generated HTML to the frontend
echo $tableRows;
?>
