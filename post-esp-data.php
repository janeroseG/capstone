<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";

$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $sensor = $location = $temperature = $humidity = "";
$temperature1 = $humidity1 = $tempCelsius = $pHvalue = $conductivity = "";
$status_temperature = $status_humidity = $status_temperature1 = "";
$status_humidity1 = $status_tempCelsius = $status_pHvalue = $status_conductivity = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $location = test_input($_POST["location"]);
        $temperature = test_input($_POST["temperature"]);
        $humidity = test_input($_POST["humidity"]);
        $temperature1 = test_input($_POST["temperature1"]);
        $humidity1 = test_input($_POST["humidity1"]);
        $tempCelsius = test_input($_POST["tempCelsius"]);
        $pHvalue = test_input($_POST["pHvalue"]);
        $conductivity = test_input($_POST["conductivity"]);

        // Additional status values
        $status_temperature = test_input($_POST["status_temperature"]);
        $status_humidity = test_input($_POST["status_humidity"]);
        $status_temperature1 = test_input($_POST["status_temperature1"]);
        $status_humidity1 = test_input($_POST["status_humidity1"]);
        $status_tempCelsius = test_input($_POST["status_tempCelsius"]);
        $status_pHvalue = test_input($_POST["status_pHvalue"]);
        $status_conductivity = test_input($_POST["status_conductivity"]);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO sensordatas (
            sensor,
            location,
            temperature,
            humidity,
            temperature1,
            humidity1,
            tempCelsius,
            pHvalue,
            conductivity,
            status_temperature,
            status_humidity,
            status_temperature1,
            status_humidity1,
            status_tempCelsius,
            status_pHvalue,
            status_conductivity
            VALUES ('" . $sensor . "', '" . $location . "', '" . $temperature . "', '" . $humidity . "', '" . $temperature1 . "', '" . $humidity1 . "''" . $pHvalue . "', '" . $tempCelsius. "' , '" . $conductivity. "', 
            '" . $status_temperature . "', '" . $status_humidity . "','" . $status_temperature1 . "','" . $status_humidity1 . "','" . $status_tempCelsius . "', '" . $status_conductivity . "')";
    
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Wrong API Key provided.";
    }
} else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
