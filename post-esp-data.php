<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";

/*$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);*/

$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor = $location = $temperature = $humidity = $temperature1 = $humidity1 = $pHvalue =  $conductivity= $tempCelsius ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $location = test_input($_POST["location"]);
        $temperature = test_input($_POST["temperature"]);
        $humidity = test_input($_POST["humidity"]);
        $temperature1 = test_input($_POST["temperature1"]);
        $humidity1 = test_input($_POST["humidity1"]);
        $conductivity = test_input($_POST[" conductivity"]);
        $pHvalue = test_input($_POST["pHvalue"]);
        $tempCelsius = test_input($_POST["tempCelsius"]);
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO sensordata (sensor, location, temperature, humidity,temperature1, humidity1, pHvalue, tempCelsius, conductivity)
        VALUES ('" . $sensor . "', '" . $location . "', '" . $temperature . "', '" . $humidity . "','" . $temperature1 . "', '" . $humidity1 . "', '" . $pHvalue . "', '" . $conductivity . "', '" . $tempCelsius . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}