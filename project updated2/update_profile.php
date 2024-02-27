<?php
session_start();
require_once 'config.php';

// Check if the user has submitted the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];

    // Update the user's information in the database
    $sql = "UPDATE User SET FirstName = ?, LastName = ?, Email = ? WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $_SESSION["userID"]);
    $stmt->execute();

    // Redirect the user back to the profile page
    header("location: profile.php");
    exit;
}
?>