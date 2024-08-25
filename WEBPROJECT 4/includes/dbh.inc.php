<?php
$servername = "localhost:3307";
$dBUsername = "root";
$dBPassword = "";
$dBName = "dulmi_skincare";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
