<?php
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

$sql = "SELECT user_Id, username, email , status FROM users";
$result = mysqli_query($conn, $sql);

$tableRows = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tableRows .= '<tr>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['user_Id'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['username'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['email'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['status'] . '</td>';
        $tableRows .= '<td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-action="includes/deleteUser.inc.php?id=' . $row['user_Id'] . '" data-message="Are you sure you want to deactivate this user?">Deactivate</button>
                      </td>';
        $tableRows .= '</tr>';
    }
} else {
    $tableRows = '<tr><td colspan="4" class="text-center">No users found.</td></tr>';
}

mysqli_close($conn);

// Pass the generated HTML to the frontend
echo $tableRows;
?>
