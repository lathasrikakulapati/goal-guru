<?php
$servername = "localhost";
$username = "root";
$password = ""; // Or your actual DB password
$dbname = "goalguru";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
