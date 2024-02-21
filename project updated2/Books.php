<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$host = 'sql200.infinityfree.com';
$db = 'if0_35176689_db_library';
$user = 'if0_35176689';
$pass = 'qQJY4USNIKZj6';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $opt);

$sql = "
    SELECT Book.BookID, Book.Title, Book.ISBN, Author.AuthorName, Genre.GenreName, Publisher.PublisherName, Book.PublicationYear, Book.Quantity
    FROM Book
    JOIN Genre ON Book.GenreID = Genre.GenreID
    JOIN Publisher ON Book.PublisherID = Publisher.PublisherID
    JOIN Author ON Book.AuthorID = Author.AuthorID
    LIMIT 10
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll();

echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <style>
        .book-row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }
        .book-item {
            flex-shrink: 0;
            margin-right: 16px;
        }
        .book-image {
            width: 128px;
            height: 192px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="book-row">
';

foreach ($books as $book) {
    echo '
    <div class="book-item">
        <img src="book.jpg" alt="' . htmlspecialchars($book['Title']) . '" class="book-image">
        <div>
            <h2>' . htmlspecialchars($book['Title']) . '</h2>
            <p>Author: ' . htmlspecialchars($book['AuthorName']) . '</p>
            <p>Genre: ' . htmlspecialchars($book['GenreName']) . '</p>
            <p>Publisher: ' . htmlspecialchars($book['PublisherName']) . '</p>
            <p>Publication Year: ' . htmlspecialchars($book['PublicationYear']) . '</p>
            <p>Quantity: ' . htmlspecialchars($book['Quantity']) . '</p>
            <button>Request</button>
        </div>
    </div>
    ';
}

echo '
    </div>
</body>
</html>
';