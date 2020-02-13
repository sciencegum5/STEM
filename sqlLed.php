<!DOCTYPE html>
<html>

<head>
    <title>
        GPIO LED
    </title>
</head>

<body style="text-align:center;">

    <h1 style="color:green;">
        GPIO LED CONTROL
    </h1>


    <?php
    //use an if statement to trigger php functions
        if(array_key_exists('offButton', $_POST)) { 
            offButton(); 
        } 
        else if(array_key_exists('onButton', $_POST)) { 
            onButton(); 
        } 
        //define our php functions 
        function offButton() { 
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

    $sql = "UPDATE led SET toggleOne=1 "; //update our value to toggle our led
    $result = $conn->query($sql); //holds result of the query

    if ($conn->query($sql) === TRUE) {//tell user if the sql query failed
        echo "Record successfully updated";
    }
    else {
        echo "Error: " .$sql . "<br>" . $conn->error;
    }
    //close connection to database
    $conn->close(); 
        } 
        function onButton() { 
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

    $sql = "UPDATE led SET toggleOne=2 "; //update our value to toggle our led
    $result = $conn->query($sql); //holds result of the query

    if ($conn->query($sql) === TRUE) {//tell user if the sql query failed
        echo "Record successfully updated";
    }
    else {
        echo "Error: " .$sql . "<br>" . $conn->error;
    }
    //close connection to database
    $conn->close(); 
        }  
    ?>
    <!-- use a form to automatically execute our php functions -->
    <form method="post">
        <input type="submit" name="offButton" class="button" value="offButton" />

        <input type="submit" name="onButton" class="button" value="onButton" />
    </form>
    </head>

</html>