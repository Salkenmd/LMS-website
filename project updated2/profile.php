<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION["userID"])) {
  header("Location: log.html"); // Redirect to the login page if the user is not logged in
  exit();
}

// Connect to the database
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_libraryabb";
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the userID of the currently logged-in user
    $userID = $_SESSION["userID"];

    // Your database query logic to retrieve user data goes here
    // For example, using prepared statements to prevent SQL injection
    $sql = "SELECT * FROM User WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of the user
        $row = $result->fetch_assoc();
        echo "<h1>User Profile</h1>";
        echo "<p>Username: " . $row["username"] . "</p>";
        echo "<p>First Name: " . $row["firstName"] . "</p>";
        echo "<p>Last Name: " . $row["lastName"] . "</p>";
        echo "<p>Email: " . $row["email"] . "</p>";
        // You can display more user information here
    } else {
        echo "No user found";
    }

    $stmt->close(); // Close the prepared statement
}

$conn->close(); // Close the database connection
?>  