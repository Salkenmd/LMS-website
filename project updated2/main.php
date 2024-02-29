<?php
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

// Define the SQL query
$sql = "SELECT * FROM Book";

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
            // Loop through the query results and display each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['Title']) . "</td><td>" . htmlspecialchars($row['Quantity']) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button id="profile-button" class="btn btn-primary">View Profile</button>
    <div id="profile-window" style="display:none;">
        <?php include('profile.php'); ?>
    </div>
    <script>
        document.getElementById('profile-button').addEventListener('click', function() {
  var profileWindow = document.getElementById('profile-window');
  if (profileWindow.style.display === 'none' || profileWindow.style.display === '') {
    profileWindow.style.display = 'block';
  } else {
    profileWindow.style.display = 'none';
  }
});
    </script>
    
    <button id="sort-button">Sort by Title</button>
    <script src="script.js"></script>
    
</body>
</html>
// Close the database connection
$conn->close();
