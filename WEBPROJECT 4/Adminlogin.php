<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!--For icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>Epicare Skincare | Login</title>
</head>
<body>
 <!----------------------- Main Container -------------------------->
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!----------------------- Login Container -------------------------->
    <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" >
       
    
    <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
          <div class="row align-items-center">
                <div class="header-text mb-4">
                     <h2 style = "font-family: 'Dancing Script', sans-serif">EpiCare SkinCare</h2>
                     <p>Inventory Management Sytem</p>
                     <hr>
                     <h3 style ="color:#be994e">Admin Login</h3>
                     
                </div>
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $message = '';

                    switch ($error) {
                        case 'emptyfields':
                            $message = 'Fill in all fields!';
                            break;
                        case 'sqlerror':
                            $message = 'Database error!';
                            break;
                        case 'wrongpassword':
                            $message = 'Incorrect password!';
                            break;
                        case 'nouser':
                            $message = 'No user found!';
                            break;
                        
                    }

                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $message;
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                }
                ?>

                <form action = "includes/Adminlogin.inc.php" method = "post">
                <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control form-control-lg bg-light fs-6" name="uid" placeholder="Username or Email address">
                </div>
                <div class="input-group mb-3 ">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control form-control-lg bg-light fs-6"  name="pwd" placeholder="Password">
                </div>
                
                <div class="input-group mb-1">
                    <button type = "submit" name="submit" class="btn btn-lg custom-button w-100 fs-6">Login</button>
                </div>
                </form>
                
              <center>  <p style = "color:white ; font-size : 12px">Don't have an account? <a href="signup.php" style = "color:orange">Sign up here</a></p></center>
              <center><a href="Userlogin.php" style = "color:orange">switch to User</a></p></center>
          </div>
       </div> 
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>