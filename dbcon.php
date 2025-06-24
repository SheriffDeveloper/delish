<?php
$servername = "localhost"; // Update with Truehost database server address
$username = "bdtavkfz_sheriff"; // Your Truehost database username
$password = "07012927918Sms@"; // Your Truehost database password
$dbname = "bdtavkfz_delishgo"; // Your Truehost database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
