<?php

    if (isset($_POST['display_books'])) {
        $host = "sql200.infinityfree.com";
        $dbusername = "if0_35176689";
        $dbpassword = "qQJY4USNIKZj6";
        $database = "if0_35176689_db_library";
        $conn = new mysqli($host, $dbusername, $dbpassword, $database);
        $search = $_POST['search'];
        $sql = "SELECT * FROM Book WHERE Title LIKE '%$search%'";
        $result = mysqli_query($conn, $sql);
        echo"<!DOCTYPE html>
        <html>
        <head>
            <title>Main Page</title>
        </head>
        <?php 
        include('main.php');
        include('showallbooks.php');
        ?>
        <body>
            <form action='main.php' method='post'>
                <input type='text' name='search' placeholder='Search by title...'>
                <button type='submit' name='display_books'>Display Books</button>
            </form>
        </body>
        </html>";
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Title</th><th>Quantity</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>" . $row['Title'] . "</td><td>" . $row['Quantity'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No books found.";
        }
    }
?>