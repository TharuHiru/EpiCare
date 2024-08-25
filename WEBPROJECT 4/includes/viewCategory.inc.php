<?php
require 'dbh.inc.php'; // Include your database connection

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
