<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'sql200.infinityfree.com';
    $db = 'if0_35176689_db_library';
    $user = 'if0_35176689';
    $pass = 'qQJY4USNIKZj6';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $pdo = new mysqli($host, $user, $pass, $db);

    if ($pdo->connect_error) {
        die("Connection failed: " . $pdo->connect_error);
    }

    $sql = "SELECT Book.BookID, Book.Title, Book.ISBN, Author.AuthorName, Genre.GenreName, Publisher.PublisherName, Book.PublicationYear, Book.Quantity FROM Book JOIN Genre ON Book.GenreID = Genre.GenreID JOIN Publisher ON Book.PublisherID = Publisher.PublisherID JOIN Author ON Book.AuthorID = Author.AuthorID;";
    $result = $pdo->query($sql);

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
    </style>
</head>
<body>
    <div class="book-row">
    ';

    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="book-item">
            <div>
                <h2>' . htmlspecialchars($row['Title']) . '</h2>
                <p>Author: ' . htmlspecialchars($row['AuthorName']) . '</p>
                <p>Genre: ' . htmlspecialchars($row['GenreName']) . '</p>
                <p>Publisher: ' . htmlspecialchars($row['PublisherName']) . '</p>
                <p>Publication Year: ' . htmlspecialchars($row['PublicationYear']) . '</p>
                <p>Quantity: ' . htmlspecialchars($row['Quantity']) . '</p>
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

    $pdo->close();
} else {
    echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
</head>
<body>
    <h1>Welcome to the Library!</h1>
    <p>Please click the button below to view the list of books.</p>
    <form action="books.php" method="post">
        <button type="submit">Show Books</button>
    </form>
</body>
</html>
';
}
?>