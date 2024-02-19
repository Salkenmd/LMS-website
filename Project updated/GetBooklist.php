<?php

// Connect to Book database (replace with your actual credentials)

$book_conn = new mysqli("sql200.infinityfree.com", "if0_35176689", "qQJY4USNIKZj6", "if0_35176689_db_library");



// Ensure proper error handling and secure connections

if ($book_conn->connect_error) {

    die("Connection failed: " . $book_conn->connect_error);

}



// Get book data from database

$sql = "SELECT Book.BookID, Book.Title, Genre.GenreName, Author.AuthorName, Publisher.PublisherName

        FROM Book

        INNER JOIN Genre ON Book.GenreID = Genre.GenreID

        INNER JOIN Author ON Book.AuthorID = Author.AuthorID

        INNER JOIN Publisher ON Book.PublisherID = Publisher.PublisherID"; // Assuming correct JOINs



$result = $book_conn->query($sql);



// Generate book list HTML

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<article class='book-item'>";
        echo "<a href='book.php?id=" . $row["BookID"] . "'>";
        echo "<img src='" . $row["ImageURL"] . "' alt='" . $row["Title"] . " Cover'>"; // Use the ImageURL from the database
        echo "<h3>" . $row["Title"] . "</h3>";
        echo "<p>" . $row["AuthorName"] . " (" . $row["GenreName"] . ") - " . $row["PublisherName"] . "</p>";
        echo "</a>";
        echo "</article>";
    }
} else {
    echo "No books found";
}



// Close connection

$book_conn->close();

?>

