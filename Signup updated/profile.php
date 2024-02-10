<?php
session_start(); // Start the session

if (isset($_SESSION["userID"])) {
    $userID = $_SESSION["userID"];

    $host = "sql200.infinityfree.com";
    $dbusername = "if0_35176689";
    $dbpassword = "qQJY4USNIKZj6";
    $database = "if0_35176689_db_libraryabb";
    $conn = new mysqli($host, $dbusername, $dbpassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM User WHERE userID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, retrieve user information including role
        $row = $result->fetch_assoc();
        $username = htmlspecialchars($row["username"]); // Sanitize output to prevent XSS
        $firstName = htmlspecialchars($row["firstName"]);
        $lastName = htmlspecialchars($row["lastName"]);
        $email = htmlspecialchars($row["email"]);
        // Retrieve the role or any other information you need

        echo "Username: " . $username . "<br>";
        echo "First Name: " . $firstName . "<br>";
        echo "Last Name: " . $lastName . "<br>";
        echo "Email: " . $email . "<br>";
        // Output the role or any other information
    } else {
        echo "User not found";
    }

    $stmt->close();
    $conn->close();
} else {
    // If userID is not set in the session, handle the case where the user is not logged in
    echo "User is not logged in";
}
?>