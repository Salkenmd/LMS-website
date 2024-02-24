<?php
// Connect to the database
$conn = mysqli_connect("sql200.infinityfree.com", "if0_35176689", "qQJY4USNIKZj6", "if0_35176689_db_library");

// Check connection
if (!$conn) {
  die("Connection failed " . mysqli_connect_error());
}

// Fetch all books from the Book table
$sql = "SELECT Title, Quantity FROM Book";
$result = mysqli_query($conn, $sql);

// Display all books in a table
if (mysqli_num_rows($result) > 0) {
  echo "<table><tr><th>Title</th><th>Quantity</th></tr>";
  // Output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $row["Title"]. "</td><td>" . $row["Quantity"]. "</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}

// Close the connection
mysqli_close($conn);
?>