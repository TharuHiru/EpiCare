<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: Adminlogin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Dulmi Skincare | Home</title>
</head>
<body>
    <div class="container">
        <h1>Welcome to Dulmi Skincare Inventory Management System</h1>
        <p>You are logged in as <?php echo $_SESSION['userUid']; ?>.</p>
        <a href="includes/logout.inc.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
