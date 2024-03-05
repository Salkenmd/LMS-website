<?php
// Start session
session_start();

// Database connection details
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

// Define the SQL query to select all books
$sql = "SELECT * FROM Book";

// Handle saving book title when form submitted
if (isset($_POST['save_book_title'])) {
    $bookTitle = $_POST['book_title'];
    $_SESSION['selectedBookTitle'] = $bookTitle;
    header("Location: book.php"); // Redirect to book.php
    exit; // Stop further execution
}

// Execute the SQL query
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Main.css">
</head>
<body>
    <!-- Search form -->
    <form action="main.php" method="post">
        <input type="text" id="search-input" name="search" placeholder="Search by title...">
        <button type="submit" name="display_books">Display Books</button>
    </form>
    
    <!-- Form to save book title -->
    <form action="main.php" method="post">
        <input type="text" id="book-title-input" name="book_title" placeholder="Enter book title...">
        <button type="submit" name="save_book_title">Save Book Title</button>
    </form>
    
    <!-- Display books in a table -->
    <table id="books-table" border='1'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the query results and display each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['Title']) . "</td><td>" . htmlspecialchars($row['Quantity']) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <!-- Profile button to toggle profile window -->
    <button id="profile-button" class="btn btn-primary">View Profile</button>
    <div id="profile-window" style="display:none;">
        <?php include('profile.php'); ?>
    </div>
    
    <!-- JavaScript to toggle profile window -->
    <script>
        document.getElementById('profile-button').addEventListener('click', function() {
            var profileWindow = document.getElementById('profile-window')
            if (profileWindow.style.display === 'none' || profileWindow.style.display === '') {
                profileWindow.style.display = 'block'
            } else {
                profileWindow.style.display = 'none'
            }
        });
    </script>
    
    <!-- Display book list as an unordered list -->
    <h2>Book List</h2>
    <ul id="book-list"></ul>
    <script>
        const bookList = document.getElementById('book-list')
        // Loop through the query results and add each title as a list item
        <?php while ($row = $result->fetch_assoc()) { ?>
            bookList.innerHTML += `<li><a href="main.php?title=${encodeURIComponent(htmlspecialchars($row['Title']))}">${htmlspecialchars($row['Title'])}</a></li>`;
        <?php } ?>
    </script>
    
    <!-- Sort button -->
    <button id="sort-button">Sort by Title</button>
    <script src="script.js"></script>
    
    <!-- Navigation buttons -->
    <button><a href="Reg.html">Register</a></button>
    <button><a href="main.php">Main page</a></button>
    <button><a href="log.html">login</a></button>
    <button><a href="profile.php">profile</a></button>
    <button><a href="Add book.html">Add Book</a></button>
</body>
</html>
