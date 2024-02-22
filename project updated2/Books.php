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

    $dsn = ""; // Remove DSN

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, $charset);

    $sql = "SELECT Book.BookID, Book.Title, Book.ISBN, Author.AuthorName, Genre.GenreName, Publisher.PublisherName, Book.PublicationYear, Book.Quantity FROM Book JOIN Genre ON Book.GenreID = Genre.GenreID JOIN Publisher ON Book.PublisherID = Publisher.PublisherID JOIN Author ON Book.AuthorID = Author.AuthorID;";
    $result = mysqli_query($conn, $sql);

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
            width: 100%;
        }
        .book-item {
            flex-shrink: 0;
            margin-right: 16px;
            width: 25%;
            height: 300px;
            padding: 16px;
            box-sizing: border-box;
        }
        .book-title {
            font-size: 24px;
            margin-bottom: 8px;
        }
        .book-author {
            font-size: 18px;
            margin-bottom: 8px;
        }
        .book-genre {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .book-publisher {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .book-publication-year {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .book-quantity {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .book-request-button {
            font-size: 16px;
            padding: 8px 16px;
        }
    </style>
</head>
<body>
    <div class="book-row">
    ';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '
        <form class="book-item" method="post" action="book-details.php">
            <div>
                <input type="hidden" name="book-id" value="' . htmlspecialchars($row['BookID']) . '">
                <h2 class="book-title">' . htmlspecialchars($row['Title']) . '</h2>
                <p class="book-author">Author: ' . htmlspecialchars($row['AuthorName']) . '</p>
                <p class="book-genre">Genre: ' . htmlspecialchars($row['GenreName']) . '</p>
                <p class="book-publisher">Publisher: ' . htmlspecialchars($row['PublisherName']) . '</p>
                <p class="book-publication-year">Publication Year: ' . htmlspecialchars($row['PublicationYear']) . '</p>
                <p class="book-quantity">Quantity: ' . htmlspecialchars($row['Quantity']) . '</p>
                <button class="book-request-button" type="submit">Request</button>
            </div>
        </form>
        ';
    }

    echo '
    </div>
</body>
</html>
';

    mysqli_close($conn);
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