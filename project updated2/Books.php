<?php
$host = 'sql200.infinityfree.com';
$user = 'if0_35176689';
$password = 'qQJY4USNIKZj6';
$dbname = 'if0_35176689_db_library';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT Book.BookID, Book.Title, Genre.GenreName, Publisher.PublisherName, Author.AuthorName, Book.ImageURL FROM Book JOIN Genre ON Book.GenreID = Genre.GenreID JOIN Publisher ON Book.PublisherID = Publisher.PublisherID JOIN Author ON Book.AuthorID = Author.AuthorID";
$result = $conn->query($sql);

$books = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo 'No books found';
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($books);
?>