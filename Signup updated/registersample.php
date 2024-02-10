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

    $sql = "INSERT INTO User (username, firstName, lastName, email, password) VALUES ('$username', '$firstName', '$lastName', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Retrieve the auto-generated ID of the inserted user
        $userID = $conn->insert_id;

        // Store the userID in the session variable
        $_SESSION["userID"] = $userID;

        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Something went wrong. Form data was not submitted.";
}
?>