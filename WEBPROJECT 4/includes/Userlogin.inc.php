<?php
if (isset($_POST["submit"])) {
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

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];

    if (empty($uid) || empty($pwd)) {
        header("Location: ../Userlogin.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username=? OR email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Userlogin.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($row = mysqli_fetch_assoc($result)) {
                // Check if the account is active
                if ($row['status'] !== 'active') {
                    header("Location:../Userlogin.php?error=nouser");
                    exit();
                }

                // Verify the password
                $pwdCheck = password_verify($pwd, $row['password']);
                if ($pwdCheck == false) {
                    header("Location:../Userlogin.php?error=wrongpassword");
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['user_Id'];
                    $_SESSION['userUid'] = $row['username'];

                    header("Location:../Userdashboard.php?login=success");
                    exit();
                } else {
                    header("Location:../Userlogin.php?error=wrongpassword");
                    exit();
                }
            } else {
                header("Location:../Userlogin.php?error=nouser");
                exit();
            }
        }
    }
} else {
    header("Location: ../Userlogin.php");
    exit();
}
?>
