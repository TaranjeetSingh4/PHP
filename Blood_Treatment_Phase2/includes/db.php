<?php
$host = "localhost";
$dbname = "blood_treatment_system";
$username = "root";
$password = "";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
