<?php
$servername = "epicare.mysql.database.azure.com";  // Azure MySQL server address
$port = 3306;  // Default port for MySQL
$dBUsername = "EpiAdmin";  // Your MySQL username
$dBPassword = "WebAdEp12";  // Your MySQL password
$dBName = "epicare_skincare";  // Your database name

// Create connection
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName, $port);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";

// Close connection
mysqli_close($conn);
?>
