<?php
if (isset($_POST['form_type']) && $_POST['form_type'] === 'editForm') {
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

    // Retrieve form data
    $item_ID = $_POST['itemBID'];
    $item_name = $_POST['itemName'];
    $quantity = $_POST['itemQuantity'];
    $Buying_price = $_POST['itemBPrice'];
    $Selling_price = $_POST['itemSPrice'];
    $category = $_POST['itemCategory'];
    $description = isset($_POST['itemDescription']) ? $_POST['itemDescription'] : NULL;

    // Basic validation
    if (empty($item_name) || empty($quantity) || empty($Buying_price) || empty($Selling_price) || empty($category)) {
        echo "<script>alert('Please fill all the required fields.'); window.location.href='../Inventory Management.php#editModal';</script>";
        exit();
    }

    try {
        // Fetch the current image path from the database
        $sql = "SELECT image_path FROM items WHERE item_ID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $item_ID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $target_file = $row['image_path'];
        } else {
            throw new Exception("Item not found");
        }

        // Fetch the category ID based on the category name
        $sql = "SELECT categoryId FROM category WHERE category = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL preparation error");
        }

        mysqli_stmt_bind_param($stmt, "s", $category);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $categoryId = $row['categoryId'];
        } else {
            throw new Exception("Category not found");
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($image);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if the file is an image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                throw new Exception("File is not an image");
            }

            // Try to upload the file
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                throw new Exception("File upload failed");
            }
        }

        $totalInventory = $Buying_price * $quantity;

        // Prepare SQL statement to update the item
        $sql = "UPDATE items
                SET item_name = ?,
                    image_path = ?,
                    quantity = ?,
                    buying_price = ?,
                    selling_price = ?,
                    total_inventory = ?,
                    categoryId = ?,
                    description = ?
                WHERE item_ID = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL preparation error");
        }

        // Bind the parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "ssidddisi", $item_name, $target_file, $quantity, $Buying_price, $Selling_price, $totalInventory, $categoryId, $description, $item_ID);

        if (mysqli_stmt_execute($stmt)) {
            // Print JavaScript to show success message
            echo "<script>alert('Item updated successfully!'); window.location.href='../Inventory Management.php';</script>";
        } else {
            throw new Exception("Error updating item: " . mysqli_stmt_error($stmt));
        }
    } catch (Exception $e) {
        // Handle execution error
        error_log($e->getMessage());
        // Print JavaScript to show error message
        echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='../Inventory Management.php';</script>";
    }
}
?>
