<?php
include('../dbConnection.php');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['selected_date'])) {
    $selectedDate = $_POST['selected_date'];

    // Modify the SQL query to check if data exists for the selected date
    $sql = "SELECT COUNT(*) AS total FROM sensordata WHERE DATE(reading_time) = '$selectedDate'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalRecords = $row['total'];

    if ($totalRecords > 0) {
        echo "data_available"; // Data is available for the selected date
    } else {
        echo "no_data_available"; // No data available for the selected date
    }
}

$conn->close();
?>
