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
    $password = $_POST['password'];

    $sql = "SELECT userID FROM User WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User is authenticated, retrieve the userID
        $row = $result->fetch_assoc();
        $userID = $row["userID"];

        // Store the userID in the session variable
        $_SESSION["userID"] = $userID;

        echo "Login successful";
        header("Location: Profilepage.html");
        exit;
    } else {
        echo "Invalid username or password";
    }

    $conn->close();
} else {
    echo "Something went wrong. Form data was not submitted.";
}
?>