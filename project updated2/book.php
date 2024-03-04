<?php
session_start();

$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";

$bookId = isset($_POST['book_id']) ? $_POST['book_id'] : null;

// Connect to the database
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve information about the selected book based on the book ID
if ($bookId) {
    $sql = "SELECT Book.BookID, Book.Title, Book.ISBN, Book.AuthorID, Book.GenreID, Book.PublisherID, Book.PublicationYear, Book.Quantity, Author.AuthorName, Genre.GenreName, Publisher.PublisherName
            FROM Book
            INNER JOIN Author ON Book.AuthorID = Author.AuthorID
            INNER JOIN Genre ON Book.GenreID = Genre.GenreID
            INNER JOIN Publisher ON Book.PublisherID = Publisher.PublisherID
            WHERE Book.BookID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    $book = $result->fetch_assoc();

    // Check if the book exists and if there is enough quantity
    if ($book && $book['Quantity'] > 0) {
        // Decrease the quantity of the book by 1
        $sql = "UPDATE Book SET Quantity = Quantity - 1 WHERE BookID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();

        // Close the statement and the connection
        $stmt->close();
    } else {
        // Handle the case when the book does not exist or there is no quantity left
        header("Location: error.php?error=Book not found or no quantity left.");
        exit;
    }
} else {
    // Handle the case when the book ID is not provided
    header("Location: error.php?error=Book ID not provided.");
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
        <h1 class='book-title'><?php echo htmlspecialchars($book['Title']); ?></h1>
        <div class='book-info'>
            <p>Author: <?php echo htmlspecialchars($book['AuthorName']); ?></p>
            <p>Year: <?php echo htmlspecialchars($book['PublicationYear']); ?></p>
            <p>Publisher: <?php echo htmlspecialchars($book['PublisherName']); ?></p>
            <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
        <div class='request-button-container'>
            <form action='request.php' method='post'>
                <input type='hidden' name='book_id' value='<?php echo $book['BookID']; ?>'>
                <button type='submit' name='request_book' class='request-button'>Request</button>
            </form>
        </div>
    </div>
</body>
</html>