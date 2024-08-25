<!--add category to the database-->
<?php
if (isset($_POST["submit"])) {
    require 'dbh.inc.php';

    // Determine which form was submitted
    $formType = $_POST['form_type'];

    if ($formType === 'category') {
        $Cname = $_POST['Cname'];

        // Check if the box is empty
        if (empty($Cname)) {
            header("Location: ../Inventory Management.php?error=emptyfields&form=category&Cname=" . urlencode($Cname) . "#addCategory");
            exit();
        } else {
            // Prepare and execute a statement to check if the category already exists
            $sql = "SELECT categoryId FROM category WHERE category=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Inventory Management.php?error=sqlerror&form=category&Cname=" . urlencode($Cname) . "#addCategory");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $Cname);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../Inventory Management.php?error=categorytaken&form=category&Cname=" . urlencode($Cname) . "#addCategory");
                    exit();
                } else {
                    // Insert the new category into the database
                    $sql = "INSERT INTO category (category) VALUES (?)";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../Inventory Management.php?error=sqlerror&form=category&Cname=" . urlencode($Cname) . "#addCategory");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $Cname);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../Inventory Management.php?success=categoryadded&form=category#addCategory");
                        exit();
                    }
                }
            }
        }
    }
}

//add the new categoryy into the list box-->

    include 'includes/categoryList.inc.php';
?>
