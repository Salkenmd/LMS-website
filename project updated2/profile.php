<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<?php
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_libraryabb";

// Create a new database connection
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if (!isset($_SESSION["userID"])) {
    header("location: log.html");
    exit;
}

$userID = $_SESSION["userID"];

$sql = "SELECT User.*, Role.RoleName 
        FROM User 
        INNER JOIN UserRole ON User.UserID = UserRole.UserID 
        INNER JOIN Role ON UserRole.RoleID = Role.RoleID 
        WHERE User.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo '
    <div class="profile-container">
        <div class="profile-content">
            <h1>User Profile</h1>
            <form method="post" action="update_profile.php">
                <div class="profile-field">
                    <label for="username">Username:</label>
                    <span id="username">' . htmlspecialchars($user["Username"]) . '</span>
                </div>
                <div class="profile-field">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" value="' . htmlspecialchars($user["FirstName"]) . '">
                </div>
                <div class="profile-field">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" value="' . htmlspecialchars($user["LastName"]) . '">
                </div>
                <div class="profile-field">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="' . htmlspecialchars($user["Email"]) . '">
                </div>
                <div class="profile-field">
                    <label for="role">Role:</label>
                    <span id="role">' . htmlspecialchars($user["RoleName"]) . '</span>
                </div>
                <button type="submit" name="update_profile" class="profile-button">Edit</button>
            </form>
            <a href="main.php" class="profile-button">Go to Main Page</a>
        </div>
    </div>
    ';
} else {
    echo "No user found";
}

$stmt->close();
$conn->close();
?>

</body>
</html>