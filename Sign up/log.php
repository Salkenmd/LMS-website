<?php
// Establishing the database connection
$host = "sql200.infinityfree.com";
$dbusername = "if0_35176689";
$dbpassword = "qQJY4USNIKZj6";
$database = "if0_35176689_db_libraryabb";
$conn = new mysqli($host, $dbusername, $dbpassword, $database);

// Checking for database connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username =$_POST["username"];
    $password =$_POST["password"];
    $sql = "SELECT * FROM User WHERE username='" . $username . "' AND password='" . $password . "'";
    $result = $conn->query($sql);
    if ($result->num_rows>0){
        echo "Succesful!";
        header("Location: welcome.php");
    } else{
        echo "Something is not right";
    }
    
}
$conn->close();
?>