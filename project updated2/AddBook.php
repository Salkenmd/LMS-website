<?php
// Include database connection details
$servername = "sql200.infinityfree.com";
$username = "if0_35176689";
$password = "qQJY4USNIKZj6";
$dbname = "if0_35176689_db_library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
    $genre = mysqli_real_escape_string($conn, $_POST["genre"]);
    $publisher = mysqli_real_escape_string($conn, $_POST["publisher"]);
    $year = mysqli_real_escape_string($conn, $_POST["year"]);
    $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
    $imageUrl = mysqli_real_escape_string($conn, $_POST["image-url"]); // Retrieve and sanitize the image URL

    // Prepare and execute SQL statement to insert the new book data into the database using a prepared statement
    $stmt = $conn->prepare("INSERT INTO Book (Title, ISBN, AuthorID, GenreID, PublisherID, PublicationYear, Quantity, ImageURL) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiisss", $title, $isbn, $author, $genre, $publisher, $year, $quantity, $imageUrl); // Bind parameters to the prepared statement
    $stmt->execute();

    // Redirect to the main page or display a success message
    header("Location: welcome.php");
    exit(); // Terminate script execution after redirection
}
?>
