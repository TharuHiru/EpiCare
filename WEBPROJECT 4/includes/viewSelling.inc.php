<?php
require_once 'includes/dbh.inc.php'; // Database connection file

// Query to fetch all rows from the selling table
$sql = "SELECT sell_ID, user_Id, item_ID, quantity, Amount, Date FROM selling";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die('Error: ' . mysqli_error($conn));
}

// Close the connection
mysqli_close($conn);
?>
