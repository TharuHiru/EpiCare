<!--add categories into the list box when the page load-->
<?PHP
    include 'includes/dashboard.inc.php';
    //include 'includes/categoryList.inc.php';
     
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>EpiCare SkinCare | Dashboard</title>

    <style>
        .table-container {
            max-height: 500px;
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



        <body style="background-image : url(back3.png)">

            <!-------------------- navigation bars --------------------------------------->
            <nav class="nav1">
            <label class="logo" style = "font-family: 'Dancing Script', sans-serif; font-size:40px">Epicare SkinCare</label>
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

            <hr style="color:white";>   

            <!----------------------------------- buttons to go to relevant places----------------------------------->

            <a href="#addItem" class="btn btn-info" role="button" style ="margin-left:20px">Add New Item</a>
            <a href="#addCategory" class="btn btn-info" role="button" style ="margin-left:20px">Add New Category</a>
            
                
            
            <button id="downloadCsv" class="btn btn-success" style="margin-bottom: 20px;position: absolute; right: 0;margin-right:20px">Download CSV</button>


            <!-----------------------------------------------search bar and category search--------------------------------------->
            <br><br><h1 style="color:white"><center>Inventory Details<center></h1>
            <div class="filter-container" style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px; margin-top:20px">
                <!-- Category Filter -->
                <select id="categorybar" name="categorybar" class="form-select form-control-lg bg-light fs-6" style="width: 20%; border-radius: 25px; border: 1px solid #ccc; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); margin-right: 10px;">
                                <option value="" disabled selected> Select a Category </option> 
                                <?php
                                    if (!empty($categories)) {
                                        // Output each category as an option in the dropdown
                                        foreach ($categories as $category) {
                                            echo "<option>" . htmlspecialchars($category) . "</option>";
                                        }
                                    } 
                                    else {
                                        echo "<option>No categories available</option>";
                                    }
                                    ?>
                </select>
                <div class="search-bar-container" style="position: relative; width: 50%; padding-right: 40px;">
                    <i class="fas fa-search search-icon" style="position: absolute; top: 50%; left: 15px; transform: translateY(-50%); color: #999;"></i>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search for items..." 
                        style="padding-left: 40px; border-radius: 25px; border: 1px solid #ccc; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); width: 100%;">
                </div>
                <button onclick="location.reload();" class="btn btn-info" >
                    <i class="bi bi-arrow-clockwise"></i> Reload</i>
                </button>
            </div>
           
            <!------------------------------------------------ User Table ---------------------------------------------------------------->
            <div id="alert-container"></div>   
            <?php
                //$items = include 'includes/viewItems.inc.php';
                ?>
                <div class="table-container">
                <table class="table table-bordered table-striped table-hover"  style="color: white; background-color: black; width: 100%; font-size: 1.1em; margin: 0 auto;">
                    <thead>
                    <tr id="fixed-header" style="background-color:#b18224">
                            <th style="color: white; ">ID</th>
                            <th style="color: white; ">Item Name</th>
                            <th style="color: white; ">Quantity</th>
                            <th style="color: white; ">Buying Price</th>
                            <th style="color: white; ">Selling Price</th>
                            <th style="color: white; ">Total Inventory</th>
                            <th style="color: white; ">Category</th>
                            <th style="color: white; ">Image</th>
                            <th style="color: white; ">Description</th>
                            <th style="color: white; ">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $row): ?>
                                <tr>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['item_ID']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['item_name']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['buying_price']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['selling_price']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['total_inventory']) ?></td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['category']) ?></td>
                                    <td style="color: white; background-color: black">
                                    <img 
                                        src="<?= htmlspecialchars(str_replace('../', '', $row['image_path'])); ?>" 
                                        alt="<?= htmlspecialchars($row['item_name']); ?>" 
                                        style="width:100px; height:auto;" 
                                        onclick="openModal('<?= htmlspecialchars($row['image_path']); ?>')">

                                    </td>
                                    <td style="color: white; background-color: black"><?= htmlspecialchars($row['description']) ?></td>
                                    
                                    <td>
                                    <!-- Edit Button with Icon -->
                                    <a href="#" onclick="editRow(this)" class="text-white me-2"   title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Delete Button with Icon -->
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-action="includes/deleteItem.inc.php?id=<?php echo $row['item_ID']; ?>" data-message="Are you sure you want to delete this user?" class="text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">No items found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div>
                <hr style = "color:white">
            
                <section>

                <!----------------------------------------- Section to display the report ---------------------------------------------------->
            <div id="reportContainer" style="margin: auto; background-color: rgba(255, 255, 255, 0.7); width: 50%; padding: 15px; border-radius: 10px;   align-items: center; justify-content: center; margin-top:20px">                   
                    <h2 style="color:red"><center>Currunt Inventory Report<center></h2>
                    <hr>
                    <center><p id="numberOfItems"></p>
                    <p id="totalQuantity"></p>
                    <p id="totalPrice"></p>
                </div>
            <hr style = "color:white">
                <!----------------------- Main Container for add new Item form ----------------------------------------------------->

                <div class="container d-flex justify-content-center align-items-center min-vh-70" style="margin-bottom: 20px;" id="addItem">
                
                <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)" >
                
                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2 style = "color:#be994e"><i class="fas fa-user"></i> &nbsp; Add New Item</h2>
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
                                        case 'invalidprice':
                                            $message = 'The price entered is invalid.';
                                            break;
                                        case 'uploadfailed':
                                            $message = 'Image upload failed. Please try again.';
                                            break;
                                        case 'sqlerror':
                                            $message = 'An SQL error occurred. Please try again.';
                                            break;
                                        case 'categorynotfound':
                                            $message = 'The selected category was not found.';
                                            break;
                                        case 'alreadyExist':
                                            $message ='Item already exist.';
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
                        <!------------------------------------------------- form add new item------------------------------------------------->
                        
                        <form action="includes/addItem.inc.php" method="post" id="submititem" enctype="multipart/form-data">
                        <input type="hidden" name="form_type" value="item">
                            <div class="input-group mb-3 ">
                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                            <input type="text" name="Iname" placeholder="Item Name" class="form-control form-control-lg bg-light fs-6"  ></div>

                            <div class="input-group mb-3 ">
                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                            <input type="file" name="image" id = "image" accept = ".jpg, .jpeg, .png" value = "Insert an image "class="form-control form-control-lg bg-light fs-6"></div>


                            <div class="input-group mb-3 ">
                            <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                            <input type="number" name="quantity" placeholder="Quantity" class="form-control form-control-lg bg-light fs-6" pattern="[0-9]+"required min = 1 max = 9999999999></div>

                            
                            <div class="input-group mb-3 ">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="number" step="0.001" name="buy_price" placeholder="Buying Price" class="form-control form-control-lg bg-light fs-6" min = 1></div>
                            
                            <div class="input-group mb-3 ">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="number" step="0.001" name="sell_price" placeholder="Selling Price" class="form-control form-control-lg bg-light fs-6" min = 1></div>

                            <div class="input-group mb-4 ">
                            <span class="input-group-text"><i class="fa fa-th-large"></i></span>
                            <select id="category" name="category" class="form-select form-control-lg bg-light fs-6" required >
                            <option value="" disabled selected> Select a Category </option> 
                            <?php
                                if (!empty($categories)) {
                                    // Output each category as an option in the dropdown
                                    foreach ($categories as $category) {
                                        echo "<option>" . htmlspecialchars($category) . "</option>";
                                    }
                                } 
                                else {
                                    echo "<option>No categories available</option>";
                                }
                                ?>
                            
                            </select></div>

                            <div class="input-group mb-3 ">
                            <textarea id="description" name="description" class="form-control form-control-lg bg-light fs-6" rows="4" placeholder="Description"></textarea>
                            </div>

                            <div class="input-group mb-1">
                            <button type="submit" name="submititem" class="btn btn-lg custom-button w-100 fs-6">Add Item</button></div>
                        </form>
                        
                    </div>
                </div>
            
            </section>

        <hr style="color:white";>

            <!----------------------- Main Container for add new category -------------------------->

            <div class="container d-flex justify-content-center align-items-center min-vh-70" style="margin-bottom: 20px;" id="addCategory">
                
                <div class="row border rounded-5 p-3 shadow box-area d-flex justify-content-center align-items-center" style="background-color: rgba(0,0,0,0.4)" >
                
                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                        <h2 style = "color:#be994e"><i class="fas fa-th-large"></i> &nbsp; Add New Category</h2>
                        <hr>
                            </div>
                            <!------------------------------------------------- form add new category---------------------------------------------->
                        <form action="includes/addCategory.inc.php" method="post" id="category">
                        <input type="hidden" name="form_type" value="category">
                        <div class="input-group mb-3 ">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" name="Cname" placeholder="Category Name" class="form-control form-control-lg bg-light fs-6" required></div>
                        <div class="input-group mb-1">
                        <button type="submit" name="submit" class="btn btn-lg custom-button w-100 fs-6">Add Category</button></div>
                        </form>
                        
                    </div>
      
                    <?php
                            if (isset($_GET['form'])) {
                                $form = $_GET['form'];
                                $message = '';
                                $messageType = ''; // To determine if the message is error or success

                                if ($form === 'category') {
                                    if (isset($_GET['error'])) {
                                        $messageType = 'danger'; // For errors
                                        if ($_GET['error'] === 'emptyfields') {
                                            $message = 'Please fill in all fields for the category form.';
                                        } elseif ($_GET['error'] === 'categorytaken') {
                                            $message = 'This category already exists.';
                                        } elseif ($_GET['error'] === 'sqlerror') {
                                            $message = 'An SQL error occurred. Please try again.';
                                        }
                                    } elseif (isset($_GET['success']) && $_GET['success'] === 'categoryadded') {
                                        $messageType = 'success'; // For success
                                        $message = 'Category added successfully!';
                                    }

                                    if (!empty($message)) {
                                        echo '<div id="category-message" class="alert alert-' . $messageType . ' alert-dismissible fade show" role="alert">';
                                        echo $message;
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                        echo '</div>';
                                    }
                                }
                            }
                ?>
                </div>
                </div>    
      
            
                </section>
                <!----------------------------- Reusable Confirmation Modal for bootstrap confirmation messages-------------------------------->
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
            

            
            

                <!-- ------------------------------------------Bootstrap Modal for update form --------------------------------------------------->

                 <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            
                            <div id="alert-container"></div>
                                <form id="editForm" action = "includes/updateItem.inc.php" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="form_type" value="editForm">
                                    <input type="hidden" id="itemId" name="id">

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <input type="text" id="itemBID" name="itemBID" placeholder="ItemID" class="form-control form-control-lg bg-light fs-6" required readonly>
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                        <input type="text" id="itemName" name="itemName" placeholder="Item Name" class="form-control form-control-lg bg-light fs-6" required>
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png" class="form-control form-control-lg bg-light fs-6">
                                        
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fa fa-cubes"></i></span>
                                        <input type="number" id="itemQuantity" name="itemQuantity" placeholder="Quantity" class="form-control form-control-lg bg-light fs-6" pattern="[0-9]+" required min=1>
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        <input type="number" id="itemBPrice" name="itemBPrice" placeholder="Buying Price" class="form-control form-control-lg bg-light fs-6" pattern="^\d+(\.\d{1,2})?$" required min=1>
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                        <input type="number" id="itemSPrice" name="itemSPrice" placeholder="Selling Price" class="form-control form-control-lg bg-light fs-6" pattern="^\d+(\.\d{1,2})?$" required min=1>
                                    </div>

                                    <div class="input-group mb-2">
                                        <span class="input-group-text"><i class="fa fa-th-large"></i></span>
                                        <select id="itemCategory" name="itemCategory" class="form-select form-control-lg bg-light fs-6" required>
                                        <?php
                                                if (!empty($categories)) {
                                                    // Output each category as an option in the dropdown
                                                    foreach ($categories as $category) {
                                                        echo "<option>" . htmlspecialchars($category) . "</option>";
                                                    }
                                                } 
                                                else {
                                                    echo "<option>No categories available</option>";
                                                }
                                                ?>
                                            
                                            </select></div>
                                        </select>
                                    </div>

                                    <div class="input-group mb-2">
                                        <textarea id="itemDescription" name="itemDescription" class="form-control form-control-lg bg-light fs-6" rows="4" placeholder="Description"></textarea>
                                    </div>

                                    <button id = "editForm" name = "editForm" type="submit" class="btn btn-primary">Update Item</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Bootstrap Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="modalImage" src="" class="img-fluid" alt="Full Size">
                    </div>
                    </div>
                </div>
                </div>
<!-- Bootstrap JS and dependencies -->
 <!-- User Table -->
    
 <div class="table-responsive">
        <h2 style="color:white; text-align: center;margin-top: 20px;">Category Detalis</h2>
                        <table class="table table-bordered table-striped table-hover"  style="color: white; background-color: black; width: 60%; font-size: 1.1em; margin: 0 auto;margin-bottom: 20px;">
                            <thead class="thead-dark">
                                <tr style="background-color:#b18224">
                                    <th scope="col" style="width: 30%;">Category ID</th>
                                    <th scope="col" >Category Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include 'includes/viewCategory.inc.php'; ?>
                            </tbody>
                        </table>
                    </div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src = "inventory.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>




</body>
</html>
