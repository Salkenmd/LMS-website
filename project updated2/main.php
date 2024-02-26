<?php
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_library";
$conn = new mysqli($host, $dbusername, $dbpassword, $database);
$sql = "SELECT * FROM Book";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
</head>
<body>
    <form action="main.php" method="post">
        <input type="text" id="search-input" name="search" placeholder="Search by title...">
        <button type="submit" name="display_books">Display Books</button>
    </form>
    <table id="books-table" border='1'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . htmlspecialchars($row['Title']) . "</td><td>" . htmlspecialchars($row['Quantity']) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button id="sort-button">Sort by Title</button>
    <script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>