<?php
include('../dbConnection.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['export'])){
    // Retrieve the selected date from the form
    $selectedDate = $_POST['selected_date'];
    
    // Modify the SQL query to fetch only the rows with the selected date
    $sql = "SELECT id, location, temperature, humidity, temperature1, humidity1, tempCelsius, pHvalue, conductivity, reading_time FROM  sensordata WHERE DATE(reading_time) = '$selectedDate'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Set CSV headers with the title
        $csvData = "Sensor Data for Selected Date\n";
        $csvData .= "Date & Time,Temperature Outside (°C),Humidity Outside (%),Temperature Inside (°C),Humidity1 Inside (%),Water Temperature (°C),pH level,Water Conductivity\n";

        // Fetch table data and append to CSV string
        while ($row = $result->fetch_assoc()) {
            $row_reading_time = $row["reading_time"];
            $row_temperature = $row["temperature"];
            $row_humidity = $row["humidity"];
            $row_temperature1 = $row["temperature1"];
            $row_humidity1 = $row["humidity1"];
            $row_tempCelsius = $row["tempCelsius"];
            $row_pHvalue = $row["pHvalue"];
            $row_conductivity = $row["conductivity"];

            $csvData .= "$row_reading_time\",$row_temperature,$row_humidity,$row_temperature1,$row_humidity1,$row_tempCelsius,$row_pHvalue,$row_conductivity\n";
        }

         // Set headers for CSV file download with dynamic filename
         $filename = "sensordatas_$selectedDate.csv";
         header("Content-type: text/csv");
         header("Content-Disposition: attachment; filename=$filename");

        // Output CSV data
        echo $csvData;
    } else {
        // No data found, display notification banner
        echo '<div style="background-color: #f44336; color: white; text-align: center; padding: 10px;">No selected Date.</div>';
        
    }

    $conn->close();
}
?>
