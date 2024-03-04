<?php
session_start();

$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";

$bookTitle = isset($_SESSION['book_title']) ? $_SESSION['book_title'] : null;

// Connect to the database
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the book ID based on the book title
if ($bookTitle) {
    $sql = "SELECT BookID FROM Book WHERE Title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $bookTitle);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookId = $result->fetch_assoc();

    // Check if the book exists and if there is enough quantity
    if ($bookId && $bookId['Quantity'] > 0) {
        // Decrease the quantity of the book by 1
        $sql = "UPDATE Book SET Quantity = Quantity - 1 WHERE BookID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookId['BookID']);
        $stmt->execute();

        // Close the statement and the connection
        $stmt->close();
    } else {
        // Handle the case when the book does not exist or there is no quantity left
        header("Location: error.php?error=Book not found or no quantity left.");
        exit;
    }
} else {
    // Handle the case when the book title is not provided
    header("Location: error.php?error=Book title not provided.");
    exit;
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class='book-container'>
        <h1 class='book-title'><?php echo htmlspecialchars($bookId['Title']); ?></h1>
        <div class='book-info'>
            <p>Author: <?php echo htmlspecialchars($bookId['AuthorName']); ?></p>
            <p>Year: <?php echo htmlspecialchars($bookId['PublicationYear']); ?></p>
            <p>Publisher: <?php echo htmlspecialchars($bookId['PublisherName']); ?></p>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <div class='request-button-container'>
            <form action='request.php' method='post'>
                <input type='hidden' name='book_id' value='<?php echo $bookId['BookID']; ?>'>
                <button type='submit' name='request_book' class='request-button'>Request</button>
            </form>
        </div>
    </div>
</body>
</html>