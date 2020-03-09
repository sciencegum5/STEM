<html>

<head>
    <title>DHT</title>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <META HTTP-EQUIV="refresh" CONTENT="4">
    <style>
         body {
  background-image: linear-gradient(grey, black);
  color: white;
  text-align: center;
}
    </style>
</head>

<body>
    <div id="chartContainer" style="height: 50%; width: 100%; "></div>
    <?php
 //Create arrays to store humidity and temperature
 $dataHum = array();
 $dataTemp = array();
 //Store highest & lowest data
 $highestHum = 0;
 $highHumTime;
 $lowestHum = 9999;
 $lowHumTime;
 $highestTemp = 0;
 $highTempTime;
 $lowestTemp = 9999;
 $lowTempTime;
 $latestTime;
 //Credentials
 $servername = "192.168.0.200";
 $username = "humid";
 $password = "raspberry";
 $dbname = "gpioControl";
 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
 // Check connection
 if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
 }
 $sql = "SELECT * FROM DHT ORDER BY id DESC"; //order by to grab most recent records first
 $result = $conn->query($sql); //holds result of the query
 if ($result->num_rows > 0) { //check if the result contains anything
 // output data of each row
 while($row = $result->fetch_assoc()) { //make a "row" variable equal to result->fetch_assoc(), an array
//save humidity temp and time in variables
$hum = $row["humidity"];
$temp = $row["temperature"];
$timeStamp = $row["time"];
//check if current data is highest/lowest
if ($hum > $highestHum) {
$highestHum = $hum;
$highHumTime = $timeStamp;
}
elseif ($hum < $lowestHum) {
$lowestHum = $hum;
$lowHumTime = $timeStamp;
}
if ($temp > $highestTemp) {
$highestTemp = $temp;
$highTempTime = $timeStamp;
}
elseif ($temp < $lowestTemp) {
$lowestTemp = $temp;
$lowTempTime = $timeStamp;
}
$latestTime = $timeStamp;
//convert timestamp to only show month date and time
$convertToUnix = strtotime($timeStamp);
$convertedTime = date("M. d H:i:s", $convertToUnix);
//save hum and temp in an associative array
$humPoint = ["y" => $hum, "label" => $convertedTime];
$tempPoint = ["y" => $temp, "label" => $convertedTime];
//push the associative arrays into beginning of arrays
array_unshift($dataHum, $humPoint);
array_unshift($dataTemp, $tempPoint);
 }
 }
 else {
 echo "0 results";
 }
 //Convert time to human readable format
 $unixHighHumTime = strtotime($highHumTime);
 $convHighHumTime = date("M. d, Y H:i:s", $unixHighHumTime);
 $unixLowHumTime = strtotime($lowHumTime);
 $convLowHumTime = date("M. d, Y H:i:s", $unixLowHumTime);
 $unixHighTempTime = strtotime($highTempTime);
 $convHighTempTime = date("M. d, Y H:i:s", $unixHighTempTime);
 $unixLowTempTime = strtotime($lowTempTime);
 $convLowTempTime = date("M. d, Y H:i:s", $unixLowTempTime);
 //Echo out highest and lowest data
 echo "Highest humidity: ". $highestHum. " on ". $convHighHumTime. "<br>";
 echo "Lowest humidity: ". $lowestHum. " on ". $convLowHumTime. "<br>";
 echo "Highest temperature: ". $highestTemp. " on ". $convHighTempTime. "<br>";
 echo "Lowest temperature: ". $lowestTemp. " on ". $convLowTempTime. "<br>";
 echo "last time data was recieved: <div id=latestTime>". $latestTime."</div> <br>";
 //Close connection
 $conn->close(); 
?>
<p id="displayTime"></p>
    <script>
        setInterval(function(){ 
  // code block to be executed
  var d = new Date();
  var theMonth = d.getMonth + 1;
  //2020-02-28 09:08:58
        var currentTimeJS = d;
        document.getElementById("displayTime").innerHTML = currentTimeJS;
        }, 500);
        //once the window loads...
        window.onload = function () {
            //Create a canvasJS chart
            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "dark2", //"light1", "light2", "dark2
                title: { //title of graph
                    text: "DHT"
                },
                axisX: {
                    title: "Time"
                },
                axisY: { //y-axis of graph
                    title: "Humidity & Temperature"
                },
                legend: { //legends graph information
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    dockInsidePlotArea: true,
                },
                data: [{
                        name: "Humidity",
                        type: "line",
                        showInLegend: true,
                        //set all the data points related to humidity
                        dataPoints: <?php echo json_encode($dataHum, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        name: "Temperature",
                        type: "line",
                        showInLegend: true,
                        //set all the data points related to temperature
                        dataPoints: <?php echo json_encode($dataTemp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            chart.render(); //render the graph
        }
    </script>
</body>
</html>
