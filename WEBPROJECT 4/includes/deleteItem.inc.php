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

    // First, retrieve the image path from the database
    $sql = "SELECT image_path FROM items WHERE item_ID=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $imagePath);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Prepare the delete query
        $sql = "DELETE FROM items WHERE item_ID=?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            // Check if the deletion was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                // Now delete the image file if it exists
                if ($imagePath && file_exists($imagePath)) {
                    unlink($imagePath);
                }

                // Redirect to the same page after deletion
                header("Location:../inventory Management.php?delete=success");
            } else {
                // If no row was deleted, handle the error
                header("Location:../inventory Management.php?delete=error");
            }
        } else {
            // Handle SQL error in delete query
            header("Location:../inventory Management.php?delete=error");
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle SQL error in retrieving image path
        header("Location:../inventory Management.php?delete=error");
    }

    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location:../inventory Management.php?delete=error");
}
?>
