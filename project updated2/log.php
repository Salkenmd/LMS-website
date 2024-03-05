<?php

// Start the session
session_start();

// Display a message to confirm the script is running
echo "Script is running!";

// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the database connection details
    $host = "sql200.infinityfree.com";
    $dbusername = "if0_35176689";
    $dbpassword = "qQJY4USNIKZj6";
    $database = "if0_35176689_db_libraryabb";

    // Create a new database connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // Display an error message if the connection failed
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the username and password from the form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query to select the userID based on the username and password
    $sql = "SELECT userID FROM User WHERE username='$username' AND password='$password'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // User is authenticated, retrieve the userID
        $row = $result->fetch_assoc();
        $userID = $row["userID"];

        // Store the userID in the session variable
        $_SESSION["userID"] = $userID;

        // Display a success message and redirect to the profile page
        echo "Login successful";
        header("Location: profile.php");
        exit;
    } else {
        // Display an error message if the username or password is incorrect
        echo "Invalid username or password";
    }

    // Close the database connection
    $conn->close();
} else {
    // Display an error message if the form was not submitted
    echo "Something went wrong. Form data was not submitted.";
}

?>