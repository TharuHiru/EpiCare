<?php
if (isset($_POST["submit"])) {
    require 'dbh.inc.php';

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];

    if (empty($uid) || empty($pwd)) {
        header("Location: ../Adminlogin.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM admin WHERE username=? OR email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Adminlogin.php?error=sqlerror");
            echo ("sql error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $uid, $uid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($pwd, $row['password']);
                if ($pwdCheck == false) {
                    header("Location:../Adminlogin.php?error=wrongpassword");
                    
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['id'];
                    $_SESSION['userUid'] = $row['username'];

                    header("Location:../dashboard.php?login=success");
                    exit();
                } else {
                    header("Location:../Adminlogin.php?error=wrongpassword");
                    
                    exit();
                }
            } else {
                header("Location:../Adminlogin.php?error=nouser");
                
                exit();
            }
        }
    }
} else {
    header("Location: ../Adminlogin.php");
    exit();
}
?>
