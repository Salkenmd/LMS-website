<?php
session_start(); // Start the session

echo "Script is running!";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "sql200.infinityfree.com";
    $dbusername = "if0_35176689";
    $dbpassword = "qQJY4USNIKZj6";
    $database = "if0_35176689_db_libraryabb";
    $conn = new mysqli($host, $dbusername, $dbpassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $lastName = $_POST['lastName'];
    $role = $_POST['role'];

    // Insert user into User table
    $sql_user = "INSERT INTO User (username, firstName, lastName, email, password) VALUES ('$username', '$firstName', '$lastName', '$email', '$password')";
    if ($conn->query($sql_user) === TRUE) {
        // Retrieve the auto-generated ID of the inserted user
        $userID = $conn->insert_id;

        // Check if the role already exists in the Role table
        $sql_check_role = "SELECT RoleID FROM Role WHERE RoleName = '$role'";
        $result = $conn->query($sql_check_role);

        if ($result->num_rows > 0) {
            // If the role exists, retrieve the RoleID
            $row = $result->fetch_assoc();
            $roleID = $row["RoleID"];
        } else {
            // If the role doesn't exist, insert it into the Role table
            $sql_role = "INSERT INTO Role (RoleName, RoleID) VALUES ('$role', '$roleID')";
            if ($conn->query($sql_role) === TRUE) {
                // Retrieve the auto-generated ID of the inserted role
                $roleID = $conn->insert_id;
            } else {
                echo "Error: " . $sql_role . "<br>" . $conn->error;
            }
        }

        // Insert the relationship between the user and the role into the UserRoles table
        $sql_user_role = "INSERT INTO UserRole (UserID, RoleID) VALUES ('$userID', '$roleID')";
        if ($conn->query($sql_user_role) === TRUE) {
            echo "New user record and role created successfully";
        } else {
            echo "Error: " . $sql_user_role . "<br>" . $conn->error;
        }

        header("Location: log.html");
        exit();
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    header("Location: Reg.html");
    exit();
}
?>