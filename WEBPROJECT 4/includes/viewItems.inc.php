<?php
require 'dbh.inc.php';

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
