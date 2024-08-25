<?php
if (isset($_POST['submit'])) {
    try {
        require_once 'dbh.inc.php'; // Database connection file

        // Start session and retrieve user ID
        session_start();
        if (!isset($_SESSION['userId'])) {
            throw new Exception("User not logged in");
        }

        // Retrieve form data
        $userId = $_SESSION['userId'];
        $item_ID = $_POST['id'] ;
        $quantity = $_POST['quantity'] ;
        $price = $_POST['selling_price'] ;

        // Basic validation
        if (empty($item_ID) || empty($quantity) || empty($price)) {
            throw new Exception("Empty fields detected");
        }

        // Calculate total amount and get the current date and time
        $amount = $quantity * $price;
        $currentDateTime = date('Y-m-d H:i:s');

        // Check whether the selling quantity is lower than the available quantity
        $sqlCheck = "SELECT quantity FROM items WHERE item_ID = ?";
        $stmtCheck = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtCheck, $sqlCheck)) {
            throw new Exception("SQL preparation error for quantity check");
        }

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmtCheck, "i", $item_ID);
        mysqli_stmt_execute($stmtCheck);
        mysqli_stmt_bind_result($stmtCheck, $available_quantity);
        mysqli_stmt_fetch($stmtCheck);
        mysqli_stmt_close($stmtCheck);

        // Check if the selling quantity exceeds the available quantity
       // Check if the selling quantity exceeds the available quantity
       if ($quantity > $available_quantity) {
        $errorMessage = "Selling quantity exceeds available quantity";
        header("Location: ../UserDashboard.php?error=quantityoverflow&message=" . urlencode($errorMessage) . "&form=item#addItem");
        exit();
        }

        // Prepare SQL statement to insert the new item
        $sql = "INSERT INTO selling (user_Id, item_ID, quantity, Amount, Date) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("SQL preparation error");
        }

        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "iidds", $userId, $item_ID, $quantity, $amount, $currentDateTime);
        mysqli_stmt_execute($stmt);

         // Prepare SQL statement to update the item quantity in the items table
         $sqlUpdate = "UPDATE items SET quantity = quantity - ? WHERE item_ID = ?";
         $stmtUpdate = mysqli_stmt_init($conn);
 
         if (!mysqli_stmt_prepare($stmtUpdate, $sqlUpdate)) {
             throw new Exception("SQL preparation error for UPDATE");
         }
 
         // Bind parameters and execute the UPDATE statement
         mysqli_stmt_bind_param($stmtUpdate, "ii", $quantity, $item_ID);
         mysqli_stmt_execute($stmtUpdate);

        // Redirect on success
        header("Location: ../UserDashboard.php?form=item&success=itemadded#addItem");
        exit();

    } catch (Exception $e) {
        // Log the error message or handle it as needed
        error_log($e->getMessage());
        header("Location: ../UserDashboard.php?error=" . urlencode($e->getMessage()) . "&form=item#addItem");
        exit();
    }
} else {
    header("Location: ../UserDashboard.php");
    exit();
}
?>
