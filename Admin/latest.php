<?php
$msg = "";
define('TITLE', 'latest');
define('PAGE', 'latest');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
    $aEmail = $_SESSION['aEmail'];
} else {
    echo "<script> location.href='login.php'</script>";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdb";
$recordsPerPage = 10; // Set the number of records to display per page

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Calculate OFFSET value for pagination
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $recordsPerPage;

// Retrieve total records count
$sqlCount = "SELECT COUNT(*) AS total FROM sensordata";
$resultCount = $conn->query($sqlCount);
if ($resultCount) {
    $row = $resultCount->fetch_assoc();
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
}

// Retrieve data with OFFSET and LIMIT for pagination
$sqlData = "SELECT id, location, temperature, humidity, temperature1, humidity1, tempCelsius, pHvalue, conductivity, reading_time  FROM sensordata ORDER BY id DESC LIMIT $offset, $recordsPerPage";

// Assign table values to variables
$resultData = $conn->query($sqlData);
if ($resultData) {
    // Variables to store sum for averaging
    $sumTemperature = 0;
    $sumHumidity = 0;
    $sumTemperature1 = 0;
    $sumHumidity1 = 0;
    $sumTempCelsius = 0;
    $sumPHvalue = 0;
    $sumConductivity = 0;
    $rowCount = 0;
  

    while ($row = $resultData->fetch_assoc()) {
        $row_temperature = $row["temperature"];
        $row_humidity = $row["humidity"];
        $row_temperature1 = $row["temperature1"];
        $row_humidity1 = $row["humidity1"];
        $row_tempCelsius = floatval($row["tempCelsius"]);
        $row_pHvalue = $row["pHvalue"];
        $row_conductivity = $row["conductivity"];
      
        $status_temperature = ( $row_temperature != 0) ? "Active" : "Inactive";
        $status_humidity = ($row_humidity != 0) ? "Active" : "Inactive";
        $status_temperature1 = ($row_temperature1 != 0) ? "Active" : "Inactive";
        $status_humidity1 = ($row_humidity1 != 0) ? "Active" : "Inactive";
        $status_tempCelsius = ($row_tempCelsius != 0) ? "Active" : "Inactive";
        $status_pHvalue = ($row_pHvalue != 0) ? "Active" : "Inactive";
        $status_conductivity = ($row_conductivity != 0) ? "Active" : "Inactive"; 

        // Add values for averaging
        $sumTemperature += $row_temperature;
        $sumHumidity += $row_humidity;
        $sumTemperature1 += $row_temperature1;
        $sumHumidity1 += $row_humidity1;
        $sumTempCelsius += $row_tempCelsius;
        $sumPHvalue += $row_pHvalue;
        $sumConductivity += $row_conductivity;
        $rowCount++;
    }

    // Calculate averages
    $avgTemperature = $sumTemperature / $rowCount;
    $avgHumidity = $sumHumidity / $rowCount;
    $avgTemperature1 = $sumTemperature1 / $rowCount;
    $avgHumidity1 = $sumHumidity1 / $rowCount;
    $avgTempCelsius = $sumTempCelsius / $rowCount;
    $avgPHvalue = $sumPHvalue / $rowCount;
    $avgConductivity = $sumConductivity / $rowCount;

    
}

$conn->close();
?>
<div class="col-sm-12 col-md-10 text-center;" style="margin-top: 30px; left: 230px;">

    <!DOCTYPE HTML>
    <html>
    <head>
        <meta http-equiv="refresh" content="530">
        <link rel="stylesheet" href="../css/dashtable1.css">
        <script src="../Js/dashtab.js"></script>
        <!----===== Iconscout CSS ===== -->
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
            window.onload = function () {
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light1",
                    title: {
                        text: "Daily Average Record"
                    },
                    axisY: {
                        includeZero: true
                    },
                    data: [{
                        type: "column",
                        indexLabelFontColor: "#5A5757",
                        indexLabelFontSize: 16,
                        indexLabelPlacement: "outside",
                        dataPoints: [
                            { label: "Temperature", y: <?php echo $avgTemperature; ?> },
                            { label: "Humidity", y: <?php echo $avgHumidity; ?> },
                            { label: "Temperature1", y: <?php echo $avgTemperature1; ?> },
                            { label: "Humidity1", y: <?php echo $avgHumidity1; ?> },
                            { label: "TempCelsius", y: <?php echo $avgTempCelsius; ?> },
                            { label: "pHValue", y: <?php echo $avgPHvalue; ?> },
                            { label: "Conductivity", y: <?php echo $avgConductivity; ?> }
                        ]
                    }]
                });
                chart.render();
            }
        </script>
    </head>
    <body>
        <div class="latest" style="text-align: center;">
            <h1><strong>Latest Reading</strong></h1>
        </div>
        <div class="boxes">
            <div class="box box1">
                <i class="uil uil-temperature"></i>
                <span class="text">Temperature</span>
                <span class="text">Inside</span>
                <span class="number"><?php echo $row_temperature; ?></span>
            </div>
            <div class="box box2">
                <i class="uil uil-fahrenheit"></i>
                <span class="text">Humidity</span>
                <span class="text">Inside</span>
                <span class="number"><?php echo $row_humidity; ?></span>
            </div>
            <div class="box box3">
                <i class="uil uil-temperature"></i>
                <span class="text">Temperature</span>
                <span class="text">Outside</span>
                <span class="number"><?php echo $row_temperature1; ?></span>
            </div>
            <div class="box box4">
                <i class="uil uil-fahrenheit"></i>
                <span class="text">Humidity</span>
                <span class="text">Outside</span>
                <span class="number"><?php echo $row_humidity1; ?></span>
            </div>
            <div class="box box5">
                <i class="uil uil-temperature"></i>
                <span class="text">Water</span>
                <span class="text">Temperature</span>
                <span class="number"><?php echo $row_tempCelsius; ?></span>
            </div>
            <div class="box box6">
                <i class="uil uil-thermometer"></i>
                <span class="text">pH</span>
                <span class="text">Level</span>
                <span class="number"><?php echo $row_pHvalue; ?></span>
            </div>
            <div class="box box7">
                <i class="uil uil-flask"></i>
                <span class="text">Water</span>
                <span class="text">Conductivity</span>
                <span class="number"><?php echo $row_conductivity; ?></span>
            </div>
        </div>

        <div class="container">
        <div id="chartContainer" style="height: 370px; width: 50%; padding-right: 10px; margin-bottom: 20px;"></div>
<!-- Normal and Above Normal Sensors Table -->
<table id="normal-above-normal-sensors" style="height: 370px; width: 50%; padding-left: 30px; padding-right: 10px; margin-left: 20px;">
    <tr>
        <th>Sensor</th>
        <th>Status</th>
        <th>Connectivity</th>
    </tr>
    <tr>
        <td>Temperature</td>
        <?php
        $temperatureStatus = ($row_temperature == 0) ? 'Below Normal' : ($row_temperature > 25 ? 'Above Normal' : 'Normal');
        $temperatureClass = ($row_temperature == 0) ? 'below-normal-label' : ($row_temperature > 25 ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $temperatureClass; ?>">
            <?php echo $temperatureStatus; ?>
        </td>
        <td class="<?php echo $status_temperature; ?>">
            <?php echo $status_temperature; ?>
        </td>
    </tr>
    <tr>
        <td>Humidity</td>
        <?php
        $humidityStatus = ($row_humidity == 0) ? 'Below Normal' : ($row_humidity > 50 ? 'Above Normal' : 'Normal');
        $humidityClass = ($row_humidity == 0) ? 'below-normal-label' : ($row_humidity > 50 ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $humidityClass; ?>">
            <?php echo $humidityStatus; ?>
        </td>
    
        <td class="<?php echo $status_humidity; ?>">
            <?php echo $status_humidity; ?>
        </td>
    </tr>
    <tr>
        <td>Temperature1</td>
        <?php
        $temperature1Status = ($row_temperature1 == 0) ? 'Below Normal' : ($row_temperature1 > 30 ? 'Above Normal' : 'Normal');
        $temperature1Class = ($row_temperature1 == 0) ? 'below-normal-label' : ($row_temperature1 > 30 ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $temperature1Class; ?>">
            <?php echo $temperature1Status; ?>
        </td>
        <td class="<?php echo $status_temperature1; ?>">
            <?php echo $status_temperature1; ?>
        </td>
    </tr>
    <tr>
        <td>Humidity1</td>
        <?php
        $humidity1Status = ($row_humidity1 == 0) ? 'Below Normal' : ($row_humidity1 > 60 ? 'Above Normal' : 'Normal');
        $humidity1Class = ($row_humidity1 == 0) ? 'below-normal-label' : ($row_humidity1 > 60 ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $humidity1Class; ?>">
            <?php echo $humidity1Status; ?>
        </td>
        <td class="<?php echo $status_humidity1; ?>">
            <?php echo $status_humidity1; ?>
        </td>
    </tr>
    <tr>
        <td>Temp Celsius</td>
        <?php
        $tempCelsiusStatus = ($row_tempCelsius == 0) ? 'Below Normal' : ($row_tempCelsius > 25 ? 'Above Normal' : 'Normal');
        $tempCelsiusClass = ($row_tempCelsius == 0) ? 'below-normal-label' : ($row_tempCelsius > 25 ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $tempCelsiusClass; ?>">
            <?php echo $tempCelsiusStatus; ?>
        </td>
        <td class="<?php echo $status_tempCelsius; ?>">
            <?php echo $status_tempCelsius; ?>
        </td>
    </tr>
    <tr>
        <td>pH Value</td>
        <?php
        $pHValueStatus = ($row_pHvalue == 0) ? 'Below Normal' : (($row_pHvalue < 5 || $row_pHvalue > 8) ? 'Above Normal' : 'Normal');
        $pHValueClass = ($row_pHvalue == 0) ? 'below-normal-label' : (($row_pHvalue < 5 || $row_pHvalue > 8) ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $pHValueClass; ?>">
            <?php echo $pHValueStatus; ?>
        </td>
        <td class="<?php echo $status_pHvalue; ?>">
            <?php echo $status_pHvalue; ?>
        </td>
    </tr>
    <tr>
        <td>Conductivity</td>
        <?php
        $conductivityStatus = ($row_conductivity == 0) ? 'Below Normal' : (($row_conductivity < 0.04 || $row_conductivity > 1.00) ? 'Above Normal' : 'Normal');
        $conductivityClass = ($row_conductivity == 0) ? 'below-normal-label' : (($row_conductivity < 0.04 || $row_conductivity > 1.00) ? 'above-normal-label' : 'normal-label');
        ?>
        <td class="<?php echo $conductivityClass; ?>">
            <?php echo $conductivityStatus; ?>
        </td>
        <td class="<?php echo $status_conductivity; ?>">
            <?php echo $status_conductivity; ?>
        </td>
    </tr>
   
</table>


        </div>
    </body>
    </html>
</div>

<?php
include('includes/footer.php');
?>
