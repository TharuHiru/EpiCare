<?php include 'includes/dashboard.inc.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>EpiCare SkinCare | Dashboard</title>
</head>
<body style="background-image : url(back3.png)">
    <nav class="nav1">
    <label class="logo" style = "font-family: 'Dancing Script', sans-serif; font-size:40px">EpiCare SkinCare</label>
    </nav>
    <nav class="nav2">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <?php
                $currentPage = basename($_SERVER['PHP_SELF']);
                ?>
                <ul>
                    <li><a href="Dashboard.php" class="<?php echo $currentPage == 'Dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="User Management.php" class="<?php echo $currentPage == 'User Management.php' ? 'active' : ''; ?>">User Management</a></li>
                    <li><a href="Inventory Management.php" class="<?php echo $currentPage == 'Inventory Management.php' ? 'active' : ''; ?>">Inventory Management</a></li>
                    <li><a href="Inventory Tracking.php" class="<?php echo $currentPage == 'Inventory Tracking.php' ? 'active' : ''; ?>">Inventory Tracking</a></li>
                    <!--logout button-->
                    <li>
                        <button class="btn btn-danger" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmationModal" 
                            data-action="includes/logout.inc.php" 
                            data-message="Are you sure you want to log out?">Logout
                        </button>
                    </li>
                </ul>
    </nav>
    <section>
        <!----------------------- Main Container for add new item-------------------------->
        <div class="container d-flex justify-content-center align-items-center min-vh-70">
        <!----------------------- Login Container -------------------------->
        <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)" >
        
        
        <!-------------------- ------ Right Box ---------------------------->
        
       <div class="col-md-6 right-box">
          <div class="row align-items-center">
                <div class="header-text mb-4">
                <h2 style = "color:#be994e"><i class="fas fa-user"></i> &nbsp; Add New User</h2>
                     
                     <hr>
                </div>

                <!--handling errors and display responsive error messages-->
                <?php
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                    $message = '';

                    switch ($error) {
                        case 'emptyfields':
                            $message = 'Please fill in all fields.';
                            break;
                        case 'invalidmailuid':
                            $message = 'Invalid email and username.';
                            break;
                        case 'invalidmail':
                            $message = 'Invalid email.';
                            break;
                        case 'invaliduid':
                            $message = 'Invalid username.';
                            break;
                        case 'passwordcheck':
                            $message = 'Passwords do not match.';
                            break;
                        case 'usertaken':
                            $message = 'Username is already taken.';
                            break;
                        case 'sqlerror':
                            $message = 'Database error. Please try again later.';
                            break;
                    }

                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo $message;
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';


}
                    //Print success message
                    if (isset($_GET['signup']) && $_GET['signup'] == 'success') {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                        echo 'User successfully added!';
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }

                ?>
                <form action="includes/Usersignup.inc.php" method="post">
                <div class="input-group mb-3 ">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="uid" placeholder="Username" class="form-control form-control-lg bg-light fs-6"></div>

                <div class="input-group mb-3 ">
                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                <input type="text" name="mail" placeholder="Email" class="form-control form-control-lg bg-light fs-6"></div>

                <div class="input-group mb-3 ">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="pwd" placeholder="Password" class="form-control form-control-lg bg-light fs-6"></div>

                <div class="input-group mb-3 ">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="pwd-repeat" placeholder="Repeat Password" class="form-control form-control-lg bg-light fs-6"></div>

                <div class="input-group mb-1">
                <button type="submit" name="submit" class="btn btn-lg custom-button w-100 fs-6">Add User</button></div>
                </form>
                
                        
          </div>
       </div> 
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <br>
        <hr style="color:white">
    </section>
            <!-- User Table -->
            
        <div class="table-responsive">
        <h2 style="color:white; text-align: center;margin-top: 20px;">User Detalis</h2>
                        <table class="table table-bordered table-striped table-hover"  style="color: white; background-color: black; width: 70%; font-size: 1.1em; margin: 0 auto;margin-bottom: 20px;">
                            <thead class="thead-dark">
                                <tr style="background-color:#b18224">
                                    <th scope="col" >ID</th>
                                    <th scope="col" >Username</th>
                                    <th scope="col" >Email</th>
                                    <th scope="col" >status</th>
                                    <th scope="col" ></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'includes/viewUsers.inc.php'; ?>
                            </tbody>
                        </table>
                    </div>



    <!-- Reusable Confirmation Modal for bootstrap confirmation messages-->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyContent">
                    <!-- Dynamic content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmActionButton" href="#" class="btn btn-danger">Confirm</a>
                </div>
                </div>
            </div>
            </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- javascript code for bootstrap confirmation messages-->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var actionButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
            var confirmActionButton = document.getElementById('confirmActionButton');
            var modalBodyContent = document.getElementById('modalBodyContent');
            
            actionButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var actionUrl = this.getAttribute('data-action');
                    var message = this.getAttribute('data-message');
                    
                    confirmActionButton.setAttribute('href', actionUrl);
                    modalBodyContent.textContent = message;
                });
            });
        });
</script>
    
</body>
</html>