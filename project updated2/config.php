<?php
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";

// Create a new database connection
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>