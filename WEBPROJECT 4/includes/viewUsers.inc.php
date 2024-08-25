<?php
require 'dbh.inc.php';

$sql = "SELECT user_Id, username, email , status FROM users";
$result = mysqli_query($conn, $sql);

$tableRows = '';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tableRows .= '<tr>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['user_Id'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['username'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['email'] . '</td>';
        $tableRows .= '<td style="color: white; background-color: black">' . $row['status'] . '</td>';
        $tableRows .= '<td>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-action="includes/deleteUser.inc.php?id=' . $row['user_Id'] . '" data-message="Are you sure you want to deactivate this user?">Deactivate</button>
                      </td>';
        $tableRows .= '</tr>';
    }
} else {
    $tableRows = '<tr><td colspan="4" class="text-center">No users found.</td></tr>';
}

mysqli_close($conn);

// Pass the generated HTML to the frontend
echo $tableRows;
?>
