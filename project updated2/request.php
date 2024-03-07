<?php

// Initialize session
session_start();

// Define database connection details
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";

// Connect to database
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get book ID from session
$bookId = isset($_SESSION['book_id']) ? $_SESSION['book_id'] : null;

// Check if book ID is set
if (!$bookId) {
    // Redirect to error page if book ID is not set
    header("Location: error.php?error=Book ID not provided.");
    exit;
}

// Prepare SQL statement to decrement book quantity
$stmt = $conn->prepare("UPDATE Book SET Quantity = Quantity - 1 WHERE BookID = ?");
$stmt->bind_param("i", $bookId);

// Execute SQL statement
$stmt->execute();

// Check if SQL statement executed successfully
if ($stmt->affected_rows > 0) {
    // Redirect to book page if book quantity was decremented successfully
    header("Location: book.php?book_id=$bookId");
} else {
    // Redirect to error page if book quantity was not decremented successfully
    header("Location: error.php?error=Failed to decrement book quantity.");
}

// Close statement and connection
$stmt->close();
$conn->close();

?>