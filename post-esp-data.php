<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";

$api_key_value = "tPmAT5Ab3j7F9";
$api_key = $sensor = $location = $temperature = $humidity = $temperature1 = $humidity1 = $temperature2 = $humidity2 = $tempCelsius = $pHvalue =  $conductivity= "";

$apiKey = "3MHO60Q51UEZVPJC";

$field1 = $temperature;
$field2 = $humidity;
$field3 = $temperature1;
$field4 = $humidity1;
$field5 = $temperature2;
$field6 = $pHvalue;
$field7 = $tempCelsius;
$field8 = $conductivity;
// ThingSpeak API endpoint
$url = "https://api.thingspeak.com/update?api_key=$apiKey&field1=$field1&field2=$field2
&field3=$field3&field4=$field4
&field5=$field5&field6=$field6
&field7=$field7&field8=$field8";

// Send data to ThingSpeak using cURL
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

// Check if data was successfully sent to ThingSpeak
if ($response !== false) {
    echo "Data sent to ThingSpeak successfully!";
} else {
    echo "Failed to send data to ThingSpeak.";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if ($api_key == $api_key_value) {
        $sensor = test_input($_POST["sensor"]);
        $location = test_input($_POST["location"]);
        $temperature = test_input($_POST["temperature"]);
        $humidity = test_input($_POST["humidity"]);
        $temperature1 = test_input($_POST["temperature1"]);
        $humidity1 = test_input($_POST["humidity1"]);
        $temperature2 = test_input($_POST["temperature2"]); 
        
        // Check if 'humidity2' is set before using it
        if (isset($_POST["humidity2"])) {
            $humidity2 = test_input($_POST["humidity2"]);
        } else {
            $humidity2 = null; // or assign a default value
            // Optionally, you can handle the case where 'humidity2' is not set
            echo "The 'humidity2' key is not set.";
        }
        
        $tempCelsius = test_input($_POST["tempCelsius"]);
        $pHvalue = test_input($_POST["pHvalue"]);
        $conductivity = test_input($_POST["conductivity"]);

        // Construct the data to be added to sensordata node
        $dataToFirebase = [
            'sensor' => $sensor,
            'location' => $location,
            'temperature' => $temperature,
            'humidity' => $humidity,
            'temperature1' => $temperature1,
            'humidity1' => $humidity1,
            'temperature2' => $temperature2,
            'humidity2' => $humidity2,
            'tempCelsius' => $tempCelsius,
            'pHvalue' => $pHvalue,
            'conductivity' => $conductivity
        ];

        // Convert data to JSON format
        $jsonData = json_encode($dataToFirebase);

        // Firebase Realtime Database URL with node specified
        $firebaseUrl = 'https://agrictu-default-rtdb.firebaseio.com/sensordata.json';

        // Initialize cURL session
        $ch = curl_init($firebaseUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Use POST method to push data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Execute cURL session
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Handle response from Firebase (check if data is pushed successfully)
        if ($response !== false) {
            // Data pushed successfully
            echo json_encode(array('success' => true)); // Sending a success response back
        } else {
            // Failed to push data
            echo json_encode(array('success' => false)); // Sending a failure response back
        }

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO sensordata (sensor, location, temperature, humidity, temperature1, humidity1, temperature2, humidity2, tempCelsius, pHvalue, conductivity)
        VALUES ('" . $sensor . "', '" . $location . "', '" . $temperature . "', '" . $humidity . "','" . $temperature1 . "', '" . $humidity1 . "','" . $temperature2 . "', '" . $humidity2 . "','" . $tempCelsius . "', '" . $pHvalue . "', '" . $conductivity . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $apiKey = "3MHO60Q51UEZVPJC";

        $field1 = $temperature;
        $field2 = $humidity;
        $field3 = $temperature1;
        $field4 = $humidity1;
        $field5 = $temperature2;
        $field6 = $pHvalue;
        $field7 = $tempCelsius;
        $field8 = $conductivity;
        // ThingSpeak API endpoint
        $url = "https://api.thingspeak.com/update?api_key=$apiKey&field1=$field1&field2=$field2
        &field3=$field3&field4=$field4
        &field5=$field5&field6=$field6
        &field7=$field7&field8=$field8";
        
        // Send data to ThingSpeak using cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        
        // Check if data was successfully sent to ThingSpeak
        if ($response !== false) {
            echo "Data sent to ThingSpeak successfully!";
        } else {
            echo "Failed to send data to ThingSpeak.";
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
