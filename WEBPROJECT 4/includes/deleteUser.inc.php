<?php
require 'dbh.inc.php'; // Include your database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the update query to set status to "deactivated"
    $sql = "UPDATE users SET status=? WHERE user_id=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        $status = "deactive";
        mysqli_stmt_bind_param($stmt, "si", $status, $id);
        mysqli_stmt_execute($stmt);

        // Redirect to the same page after updating the status
        header("Location:../User Management.php?statusupdate=success");
    } else {
        // Handle SQL error
        header("Location:../User Management.php?statusupdate=error");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    // If no ID is provided, redirect back with an error
    header("Location:../User Management.php?statusupdate=error");
}
?>
