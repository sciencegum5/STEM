<?php
    $servername = "localhost"; //use localhost because file is on the server
    $username = "user";
    $password = "password";
    $dbname = "school";  //database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname); //instantiate mysqli object
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); //turn off connection on our end
    }
    $sql = "INSERT INTO students (name, age, gradeLevel) VALUES ('Bartholomew', 16, 10)";
    //$sql = "INSERT INTO led (toggleOne)
    //VALUES (1)";
    if ($conn->query($sql) === TRUE) { //pass sql query into object
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
?>

