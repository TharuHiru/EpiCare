<?php
$host = 'epicare.mysql.database.azure.com';
$port = 3306;
$username = 'EpiAdmin';
$password = 'WebAdEp12';
$database = 'epicare_skincare';

// Path to your SSL certificate
$ssl_ca = '/home/site/wwwroot/certs/ca-cert.pem'; // Ensure this path is correct

// Create a new MySQLi connection with SSL options
$mysqli = new mysqli();
$mysqli->ssl_set(null, null, $ssl_ca, null, null); // Set SSL options
$mysqli->real_connect($host, $username, $password, $database, $port, null, MYSQLI_CLIENT_SSL);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    // Connection failed
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
    // Connection succeeded
    echo "Connected successfully to MySQL.";

    // Verify if SSL is enabled
    $result = $mysqli->query("SHOW VARIABLES LIKE 'have_ssl'");
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['Value'] == 'YES') {
            echo " SSL is enabled on the MySQL connection.";
        } else {
            echo " SSL is not enabled on the MySQL connection.";
        }
    } else {
        echo " Failed to check SSL status: " . $mysqli->error;
    }

    // Perform a test query
    $result = $mysqli->query("SELECT NOW() AS now");
    if ($result) {
        $row = $result->fetch_assoc();
        echo " Current time: " . $row['now'];
    } else {
        echo " Query failed: " . $mysqli->error;
    }

    // Close the connection
    $mysqli->close();
}
?>
