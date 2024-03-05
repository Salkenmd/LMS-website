<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
    <!-- This is the beginning of the HTML code for the user profile page -->

<?php
// Define database connection variables
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_libraryabb";
// Initialize a new database connection
$conn = new mysqli($host, $dbusername, $dbpassword, $database);
// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION["userID"])) {
    // If not, redirect to the login page
    header("location: log.html");
    exit;
}

// Get the user ID from the session variable
$userID = $_SESSION["userID"];

// Define the SQL query to retrieve the user's information
$sql = "SELECT User.*, Role.RoleName FROM User INNER JOIN UserRole ON User.UserID = UserRole.UserID INNER JOIN Role ON UserRole.RoleID = Role.RoleID WHERE User.UserID = ?";

// Prepare the statement for execution
$stmt = $conn->prepare($sql);

// Bind the user ID parameter to the statement
$stmt->bind_param("i", $userID);

// Execute the statement
$stmt->execute();

// Get the result set from the statement
$result = $stmt->get_result();

// Check if the user exists in the database
if ($result->num_rows > 0) {
    // If so, retrieve the user's information
    $user = $result->fetch_assoc();
    // Display the user's information
    echo '
    <div class="profile-container">
        <div class="profile-content">
            <h1>User Profile</h1>
            <form method="post" action="update_profile.php">
                <div class="profile-field">
                    <label for="username">Username:</label>

                    <span id="username">' . htmlspecialchars($user["username"]) . '</span>
                </div>
                <div class="profile-field">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" value="' . htmlspecialchars($user["firstName"]) . '">
                </div>
                <div class="profile-field">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" value="' . htmlspecialchars($user["lastName"]) . '">
                </div>
                <div class="profile-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="' . htmlspecialchars($user["email"]) . '">
                </div>
    ';
} else {
    // If not, display an error message
    echo "No user found";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>

<!-- This is the beginning of the HTML code for the buttons on the user profile page -->
<button><a href="Reg.html">Register</a></button>
<button><a href="main.php">Main page</a></button>
<button><a href="log.html">login</a></button>
<button><a href="profile.php">profile</a></button>
</body>
</html>