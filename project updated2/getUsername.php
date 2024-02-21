<?php
$conn = new mysqli("sql200.infinityfree.com", "if0_35176689", "qQJY4USNIKZj6", "if0_35176689_db_libraryabb");


// Ensure proper error handling and secure connections
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Get username from database
$sql = "SELECT username FROM User WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]); // Assuming you have user ID in session
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$username = $row["username"];


// Close connection and echo username
$conn->close();
echo $username;
?>
