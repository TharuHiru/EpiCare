<!--add categories into the list box-->
<?php
// Database connection
require 'dbh.inc.php'; 

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