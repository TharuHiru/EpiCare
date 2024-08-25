<?php
if (isset($_POST['submititem'])) {
    require_once 'dbh.inc.php'; // Database connection file

    // Retrieve form data
    $item_name = $_POST['Iname'];
    $quantity = $_POST['quantity'];
    $Buying_price = $_POST['buy_price'];
    $Selling_price = $_POST['sell_price'];
    $category = $_POST['category'];
    $description = isset($_POST['description']) ? $_POST['description'] : NULL;

    // Basic validation
    if (empty($item_name) || empty($quantity) || empty($Buying_price) || empty($Selling_price) || empty($category)) {
        header("Location: ../Inventory Management.php?error=emptyfields&form=item#addItem");
        exit();
    }

    // Check if the item name already exists
    $sql = "SELECT item_Id FROM items WHERE item_name=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../Inventory Management.php?error=sqlerror&form=item#addItem");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $item_name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: ../Inventory Management.php?error=alreadyExist&form=item#addItem");
        exit();
    }



    try {
        // Fetch the category ID based on the category name
        $sql = "SELECT categoryId FROM category WHERE category = ?";
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



        // Handle image upload
        $target_file = NULL; // Default to NULL if no image is uploaded
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

        // Prepare SQL statement to insert the new item
        $sql = "INSERT INTO items (item_name, image_path, quantity, buying_price, selling_price, total_inventory, categoryId, description) VALUES (?, ?, ?, ?, ?, ?, ? , ?)";
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL preparation error");
        }

        mysqli_stmt_bind_param($stmt, "ssidddis", $item_name, $target_file, $quantity, $Buying_price, $Selling_price, $totalInventory, $categoryId, $description);
        mysqli_stmt_execute($stmt);

        header("Location: ../Inventory Management.php?form=item&success=itemadded#addItem");
        exit();
    } catch (Exception $e) {
        // Log the error message or handle it as needed
        error_log($e->getMessage());
        header("Location: ../Inventory Management.php?error=" . urlencode($e->getMessage()) . "&form=item#addItem");
        exit();
    }
}
?>
