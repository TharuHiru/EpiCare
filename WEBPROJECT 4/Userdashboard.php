<?php
// Start the session
session_start();


// Including the items data from the database

$items = include 'includes/viewItems.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap">
    <title>EpiCare SkinCare | Dashboard</title>

    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;  /* Enable vertical scrolling */
            overflow-x: auto;  /* Enable horizontal scrolling */
            border: 1px solid #ddd; 
            width: 80%;
            margin: 0 auto; /* Center the container horizontally */
            margin-bottom: 20px;
        }

        #fixed-header {
            position: sticky;
            top: 0; /* Set the top position to keep header fixed at the top */
            z-index: 2; /* Ensure the header stays on top of other content */
        }
        </style>
</head>
<body style="background-image: url(women.png);">
    <!-- Navigation -->
    <nav class="nav1">
        <label class="logo" style="font-family: 'Dancing Script', sans-serif; font-size:40px">EpiCare SkinCare</label>
    </nav>
    <nav class="nav2">
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fa fa-bars"></i>
        </label>
        <ul>
            <!-- Logout Button -->
        <li>
        <button type="button" class="btn btn-danger text-white" onclick="confirmLogout(event)">
            Logout
        </button>
        </li>
        </ul>
    </nav>

    <!-- Welcome Section -->
    <section>
        <?php include 'includes/Userdashboard.inc.php'; ?>
        <h1 style="color: #be994e"> Welcome, <?php echo htmlspecialchars($_SESSION['userUid']); ?>!</h1>
        <p style="color: #be994e">Here is your dashboard overview:</p>
    </section>

    <!-- Main Container for Add New Item Form -->
    <div class="container d-flex justify-content-center align-items-center min-vh-70" style="margin-bottom: 20px;" id="addItem">
        <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)">
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2 style="color:#be994e"><i class="fa fa-cubes"></i> &nbsp; Sell Item</h2>
                        <hr>
                    </div>

                    <?php
                    // Check if there are query parameters indicating a form submission
                    if (isset($_GET['form'])) {
                        $form = $_GET['form'];
                        $message = '';
                        $messageType = ''; // To determine if the message is an error or success

                        // Check if the form is 'item'
                        if ($form === 'item') {
                            // Handle errors
                            if (isset($_GET['error'])) {
                                $messageType = 'danger'; // For errors
                                switch ($_GET['error']) {
                                    case 'emptyfields':
                                        $message = 'Please fill in all fields for the item form.';
                                        break;
                                    case 'sqlerror':
                                        $message = 'An SQL error occurred. Please try again.';
                                        break;
                                    case 'insufficientquantity':
                                        $message = 'Insufficient quantity available.';
                                        break;
                                    case 'quantityoverflow':
                                        $message = 'The quantity exceeds the available stock.';
                                        break;
                                    default:
                                        $message = 'An unknown error occurred.';
                                        break;
                                }
                            } 
                            // Handle success
                            elseif (isset($_GET['success']) && $_GET['success'] === 'itemadded') {
                                $messageType = 'success'; // For success
                                $message = 'Item added successfully!';
                            }

                            // Display the message if it's not empty
                            if (!empty($message)) {
                                echo '<div id="item-message" class="alert alert-' . htmlspecialchars($messageType) . ' alert-dismissible fade show" role="alert">';
                                echo htmlspecialchars($message);
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>

                    <!-- Sellimg form -->
                    <form action="includes/sellItem.inc.php" method="post" id="selling" enctype="multipart/form-data" >
                        <input type="hidden" name="form_type" value="sell">
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                            <input type="text" id="id" name="id" placeholder="Item_ID" class="form-control form-control-lg bg-light fs-6" readonly >
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                            <input type="number" id = "selling_price" name="selling_price" placeholder="Selling_price" class="form-control form-control-lg bg-light fs-6" readonly >
                        </div>
                        
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                            <input type="number"id = "quantity" name="quantity" placeholder="Quantity" class="form-control form-control-lg bg-light fs-6" required min="1">
                        </div>

                        <div class="input-group mb-1">
                            <button type="submit" style="background-color: #be994e" name="submit" class="btn btn-lg custom-button w-100 fs-6">Sell Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="container mt-5">
        <h1 class="text-center" style="color:white">Available Items</h1>

        <!-- Search Bar -->
        <div class="filter-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px; margin-top:20px">
            <div class="search-bar-container" style="position: relative; width: 50%; padding-right: 40px;">
                <i class="fas fa-search search-icon" style="position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: #999; width: 100%;"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Search for items..." style="padding-left: 40px; border-radius: 25px; border: 1px solid #ccc; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); width: 100%;">
            </div>
        </div>

        <!-- Items Table -->
        
        <div class="table-container mt-4">
            <table id = "sell" class="table table-bordered table-striped table-hover" style="background-color: #b5a66e; width: 100%; font-size: 1.1em; margin: 0 auto;">
                <thead>
                    <tr style="background-color:#b18224;">
                        <th>ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Selling Price</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $row): ?>
                            <tr data-id="<?php echo htmlspecialchars($row['item_ID']); ?>">
                                <td><?= htmlspecialchars($row['item_ID']) ?></td>
                                <td><?= htmlspecialchars($row['item_name']) ?></td>
                                <td><?= htmlspecialchars($row['quantity']) ?></td>
                                <td><?= htmlspecialchars($row['selling_price']) ?></td>
                                <td><?= htmlspecialchars($row['category']) ?></td>
                                <td>
                                    <img 
                                        src="<?= htmlspecialchars(str_replace('../', '', $row['image_path'])); ?>" 
                                        alt="<?= htmlspecialchars($row['item_name']); ?>" 
                                        style="width:100px; height:auto;" 
                                        onclick="openModal('<?= htmlspecialchars($row['image_path']); ?>')">
                                </td>
                                <td><?= htmlspecialchars($row['description']) ?></td>
                                 <!-- Edit Button with Icon -->
                                 <td>
                                <a href = "#">
                                <button type="button" onclick="editRow(this)" class="btn btn-primary text-white me-2" title="Sell">
                                    Sell
                                </button></a>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">No items found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal to Display Larger Image -->
    <div id="imageModal" class="modal" style="display: none;" onclick="closeModal()">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage" style="margin:auto; display:block; max-width:90%; max-height:90vh;">
        <div id="caption" style="text-align:center; color:#ccc; padding:10px 0;"></div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmLogoutBtn">Logout</button>
                </div>
            </div>
        </div>
    </div>

    
    


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="user.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/validation.js"></script>

    
</body>
</html>
