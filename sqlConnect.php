<?php
include 'errorHandler.php';
$servername = "localhost"; //use localhost because file is on the server
    $username = "user";
    $password = "password";
    $dbname = "school";  //database name
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

while ( $tables = $result->fetch_assoc())
{
    echo "name: ".$row['name']." age: ".$row['age']." grade: ".$row['gradeLevel']."<br>";
}
$conn->close();
?>
