<?php
session_start();
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";

// Create a new database connection
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the book ID from the session
$bookId = isset($_SESSION['selectedBookTitle']) ? (int)$_SESSION['selectedBookTitle'] : 0;

// Define the SQL query
$sql = "SELECT Book.Title, Book.PublicationYear, Genre.GenreName, Publisher.PublisherName, Author.AuthorName, Book.Quantity, User.Username
        FROM Book
        JOIN Genre ON Book.GenreID = Genre.GenreID
        JOIN Publisher ON Book.PublisherID = Publisher.PublisherID
        JOIN Author ON Book.AuthorID = Author.AuthorID
        JOIN (SELECT BookID, SUM(Quantity) as Quantity FROM BookRequest GROUP BY BookID) br ON Book.BookID = br.BookID
        JOIN User ON Book.UserID = User.UserID
        WHERE Book.BookID = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind the parameter
$stmt->bind_param("i", $bookId);

// Set the value of the parameter
$bookId = $_SESSION['selectedBookTitle'];

// Execute the statement
$stmt->execute();

// Bind the result variables
$stmt->bind_result($book['Title'], $book['PublicationYear'], $book['GenreName'], $book['PublisherName'], $book['AuthorName'], $book['Quantity'], $book['Username']);

// Check if the query was successful
if (!$stmt) {
    die("Query failed: " . $conn->error);
}

// Fetch the book data
$stmt->fetch();

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Page</title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="Main.css">
    <h1><?php echo htmlspecialchars($book['Title']); ?></h1>
    <p>Author: <?php echo htmlspecialchars($book['AuthorName']); ?></p>
    <p>Year: <?php echo htmlspecialchars($book['PublicationYear']); ?></p>
    <p>Genre: <?php echo htmlspecialchars($book['GenreName']); ?></p>
    <p>Publisher: <?php echo htmlspecialchars($book['PublisherName']); ?></p>
    <p>Username: <?php echo htmlspecialchars($book['Username']); ?></p>
    <p>Quantity: <?php echo htmlspecialchars($book['Quantity']); ?></p>

    <!-- Add a request button if the user is logged in and the book has quantity -->
    <?php if (isset($_SESSION['username']) && $book['Quantity'] > 0): ?>
        <form action="request.php" method="post">
            <input type="hidden" name="bookId" value="<?php echo htmlspecialchars($bookId); ?>">
            <button type="submit" name="request_book">Request Book</button>
        </form>
    <?php endif; ?>
</body>
</html>