<?php
require_once 'includes/viewSelling.inc.php'; // Include the SQL file
include 'includes/dashboard.inc.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing Script:wght@400;700&display=swap">
    <title>EpiCare SkinCare | Dashboard</title>
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;  /* Enable vertical scrolling */
            overflow-x: auto;  /* Enable horizontal scrolling */
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
<body style="background-image: url(back3.png)">
    <nav class="nav1">
        <label class="logo" style="font-family: 'Dancing Script', sans-serif; font-size:40px">EpiCare SkinCare</label>
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
    <h2 class="text-center" style="color:white; text-align: center; margin-top: 20px;">Sales Records</h2> <!-- Table name -->
    <div class="table-container">
        <table class="table table-bordered" style="color: white; background-color: black;">
            <thead>
                <tr id="fixed-header" style="background-color:#b18224">
                    <th>Sell ID</th>
                    <th>User ID</th>
                    <th>Item ID</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['sell_ID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_Id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['item_ID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Amount']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                        echo "<td>    <a href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#confirmationModal\" 
                            data-action=\"includes/deleteSelling.inc.php?sell_ID=" . htmlspecialchars($row['sell_ID']) . "\" 
                            data-message=\"Are you sure you want to delete this record?\" 
                            class=\"btn btn-danger\">
                            Delete
                            </a>
                        </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
                    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src = "inventory.js">
        script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
