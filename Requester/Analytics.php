<?php
define('TITLE', 'Analytics');
define('PAGE', 'Analytics');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if($_SESSION['is_login']){
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'</script>";
}


?>
<div class="col-sm-9 col-md-10" style="margin-top: 50px; left: 230px">   
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";
// Set the number of records to display per page
$recordsPerPage = isset($_GET['recordsPerPage']) ? intval($_GET['recordsPerPage']) : 31;

// Get the current page number from the URL
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}
// Calculate the OFFSET value for the SQL query
$offset = ($currentPage - 1) * $recordsPerPage;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total FROM sensordata";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$sql = "SELECT id, location, temperature, humidity, temperature1, humidity1, reading_time , tempCelsius,pHvalue, conductivity FROM  sensordata ORDER BY id DESC LIMIT $offset, $recordsPerPage";
//Variables
$dataPoints = array();
$dataPoints2 = array();
$dataPoints3 = array();
$dataPoints4 = array();
$dataPoints4b = array();

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_temperature = $row["temperature"];
        $row_humidity = $row["humidity"];
        $row_temperature2 = $row["temperature1"];
        $row_humidity2 = $row["humidity1"];

        $row_tempCelsius = $row["tempCelsius"];
        $row_conductivity = $row["conductivity"];
        $row_pHvalue = $row["pHvalue"];

        $dataPoints[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_temperature, "name" => "Temperature");
        $dataPointsh[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_humidity, "name" => "Humidity");

        $dataPoints2[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_temperature2, "name" => "Temperature2");
        $dataPoints2h[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_humidity2, "name" => "Humidity2");
        $dataPoints4[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_conductivity, "name" => "conductivity");
       

        $dataPoints3[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_tempCelsius, "name" => "tempCelsius");
        $dataPoints4b[] = array("x" => strtotime($row["reading_time"]) * 1000, "y" => $row_pHvalue, "name" => "pHvalue");
    }
    $result->free();
}
$conn->close();

?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="../css/analytics.css">
<script>
window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        backgroundColor: "#D9D9D9",
        animationEnabled: true,
        title: {
        text: "Temperature and Humidity Outside",
        fontFamily: "Roboto, sans-serif" 
    },
        axisY: {
            title: "Temperature / Humidity",
            valueFormatString: "#0.##",
            suffix: "Cel",
            prefix: ""
        },
        axisX: {
            title: "Time",
            valueFormatString: "h:mm TT", 
            interval: 120, 
            intervalType: "minute",
            labelAngle: -45, 
            timeZoneOffset: new Date().getTimezoneOffset()
        },
        data: [{
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "red",
            markerColor: "red" 
        }, {
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPointsh, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "blue", 
            markerColor: "blue" 
        }]
    });

    chart.render();

    var chart2 = new CanvasJS.Chart("chartContainer2", {
        backgroundColor: "#D9D9D9",
        animationEnabled: true,
        title: {
        text: "Temperature2 and Humidity2 Outside",
        fontFamily: "Roboto, sans-serif" 
    },
        axisY: {
            title: "Temperature2 / Humidity2",
            valueFormatString: "#0.##",
            suffix: "Cel",
            prefix: ""
        },
        axisX: {
            title: "Time",
            valueFormatString: "h:mm TT", // Format time as 12-hour with AM/PM
            interval: 120, // Set interval to 2 hours (120 minutes)
            intervalType: "minute",
            labelAngle: -45, // Rotate labels for better readability (optional)
            timeZoneOffset: new Date().getTimezoneOffset()
        },
        data: [{
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "green", // Set color as green for temperature2
            markerColor: "green" // Set marker color as green for temperature2
        }, {
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints2h, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "purple", // Set color as purple for humidity2
            markerColor: "purple" // Set marker color as purple for humidity2
        }]
    });
    chart2.render();
    
    var chart3 = new CanvasJS.Chart("chartContainer3", {
        backgroundColor: "#D9D9D9",
        animationEnabled: true,
        title: {
        text: "Water Conductivity",
        fontFamily: "Roboto, sans-serif" // Set a font family without bold weight
    },
        axisY: {
            title: "Temperature",
            valueFormatString: "#0.##",
            suffix: "Cel",
            prefix: ""
        },
        axisX: {
            title: "Time",
            valueFormatString: "h:mm TT", 
            interval: 120,
            intervalType: "minute",
            labelAngle: -45, 
            timeZoneOffset: new Date().getTimezoneOffset()
        },
        data: [{
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "black",
            markerColor: "black" 
        }]
    });

    chart3.render();

    var chart4 = new CanvasJS.Chart("chartContainer4", {
        backgroundColor: "#D9D9D9",
        animationEnabled: true,
        title: {
        text: "pH Level - Water Temperature",
        fontFamily: "Roboto, sans-serif" 
    },
        axisY: {
            title: "pH/Temperature",
            valueFormatString: "#0.##",
            suffix: "Cel",
            prefix: ""
        },
        axisX: {
            title: "Time",
            valueFormatString: "h:mm TT", 
            interval: 120, 
            intervalType: "minute",
            labelAngle: -45, 
            timeZoneOffset: new Date().getTimezoneOffset()
        },
        data: [{
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "orange", 
            markerColor: "orange" 
        }, {
            type: "spline",
            markerSize: 5,
            xValueFormatString: "h:mm TT",
            yValueFormatString: "#0.##",
            xValueType: "dateTime",
            dataPoints: <?php echo json_encode($dataPoints4b, JSON_NUMERIC_CHECK); ?>,
            showInLegend: true,
            legendText: "{name}",
            color: "yellow", 
            markerColor: "yellow" 
        }]
    });

    chart4.render();

    
}
function setRecordsPerPage(records) {
        // Redirect to the same page with the selected number of records as a query parameter
        window.location.href = `Analytics.php?recordsPerPage=${records}`;
    }
</script>
<nav class="navbar navbar-dark fixed-top bg-success flex-md-nowrap p-0 ">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 logo" href="Dashboard.php">
      <img src="../images/agri (2).png" alt="Logo" style="height: 70px; width: 80px; padding-bottom:1px; margin-left: 50px">
    </a>
    <div class="customize left-230px">
    <button class="custom-button" onclick="setRecordsPerPage(12)">Daily</button>
    <button class="custom-button" onclick="setRecordsPerPage(12*7)">Weekly</butto>
    <button class="custom-button" onclick="setRecordsPerPage(12*31)">Monthly</butto>

</div>
</nav>
</head>
<body>


<div class="container1">
<div id="chartContainer" style="height: 370px; width: 40%; padding-left: 30px; padding-right: 20px;"></div>
<div id="chartContainer4" style="height: 370px; width: 40%; padding-left:30px; padding-right: 20px; padding-top: 30px;"></div>
</div>
<style>
  .container {
    display: flex;
    float: right;
    flex-direction: row;
    font-weight: normal;
    padding: 10px;
    padding-bottom: 20px;
    padding-top: 5px; 
  }
.container1 {
    padding-left: 20px;
    margin-left: 40px; 
  }
  .chart-container {
  
    width: 50%;
    margin-right: 10px;
    position: absolute;
    top: 0;
    right: 0;
    font-weight: normal;
    padding-bottom: 20px;
  }

  #chartContainer2 {
  
    height: 370px;
    width: 80%;
    padding: 10px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 3px;
  }

  #chartContainer3 {
   
    height: 370px;
    width: 80%;
    padding: 20px; 
    padding-left: 20px;
    padding-right: 20px;
  }
</style>


<div class="container">
  <div class="chart-container">
    <div id="chartContainer2" style="height: 370px; width: 80%; padding: 10px; padding-left: 20px; padding-right: 20px; margin-top:-5px;"></div>
    <div id="chartContainer3" style="height: 370px; width: 80%; padding-left: 20px; padding-right: 20px; padding-top: 30px;"></div>
  </div>
</div>


<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<script>
setTimeout(function() {
    location.reload();
}, 5 * 60 * 1000);
</script>
</body>
</html>
</div>
    </script>
<?php
include('includes/footer.php');
?>