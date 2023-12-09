<?php
$msg = "";
define('TITLE', 'Dashboard');
define('PAGE', 'Dashboard');

include('includes/header.php');
include('../dbConnection.php');
session_start();

if ($_SESSION['is_login']) {
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'</script>";
    exit();
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

// Initialize variables
$avgTemperature = $avgHumidity = $avgTemperature1 = $avgHumidity1 = $avgTemperature2 = $avgTempCelsius = $avgPHvalue = $avgConductivity = 0;
$row_temperature = $row_humidity = $row_temperature1 = $row_humidity1 = $row_temperature2 = $row_tempCelsius = $row_pHvalue = $row_conductivity = 0;

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
} else {
    // Handle query error
    die("Error executing query: " . $conn->error);
}

// Retrieve data with OFFSET and LIMIT for pagination
$sqlData = "SELECT id, location, temperature, humidity, temperature1, humidity1, temperature2, tempCelsius, pHvalue, conductivity, reading_time  FROM sensordata ORDER BY id DESC LIMIT $offset, $recordsPerPage";

// Assign table values to variables
$resultData = $conn->query($sqlData);

if ($resultData) {
    // Variables to store sum for averaging
    $sumTemperature = $sumHumidity = $sumTemperature1 = $sumHumidity1 = $sumTemperature2 = $sumTempCelsius = $sumPHvalue = $sumConductivity = $rowCount = 0;

    while ($row = $resultData->fetch_assoc()) {
        // Check if the data exists before accessing it
        $row_temperature = $row["temperature"];
        $row_humidity = $row["humidity"];
        $row_temperature1 = $row["temperature1"];
        $row_humidity1 =$row["humidity1"];
        $row_temperature2 = $row["temperature2"];
        $row_tempCelsius = $row["tempCelsius"];
        $row_pHvalue = $row["pHvalue"];
        $row_conductivity = $row["conductivity"];

        // for active status 
        $status_temperature = (is_numeric($row_temperature) && !is_nan(floatval($row_temperature)) && $row_temperature != 0) ? "active" : "not-active";
        $status_humidity = (is_numeric($row_humidity) && !is_nan(floatval($row_humidity)) && $row_humidity != 0) ? "active" : "not-active";
        $status_temperature1 = (is_numeric($row_temperature1) && !is_nan(floatval($row_temperature1)) && $row_temperature1 != 0) ? "active" : "not-active";
        $status_humidity1 = (is_numeric($row_humidity1) && !is_nan(floatval($row_humidity1)) && $row_humidity1 != 0) ? "active" : "not-active";
        $status_temperature2 = (is_numeric($row_temperature2) && !is_nan(floatval($row_temperature2)) && $row_temperature2 != 0) ? "active" : "not-active";

        $status_tempCelsius = ($row_tempCelsius != 0) ? "active" : "not-active";
        $status_pHvalue = ($row_pHvalue != 0) ? "active" : "not-active";
        $status_conductivity = ($row_conductivity != 0) ? "active" : "not-active";

        // Add values for averaging
        $sumTemperature = 0;
        $sumHumidity = 0;
        $sumTemperature1 = 0;
        $sumHumidity1 = 0;
        $sumTemperature2 = 0;
        $sumTempCelsius = 0;
        $sumPHvalue = 0;
        $sumConductivity = 0;
        $rowCount = 0;
        
        while ($row = $resultData->fetch_assoc()) {
            // Check if the data exists before accessing it
            $row_temperature = isset($row["temperature"]) ? $row["temperature"] : 0;
            $row_humidity = isset($row["humidity"]) ? $row["humidity"] : 0;
            $row_temperature1 = isset($row["temperature1"]) ? $row["temperature1"] : 0;
            $row_temperature2 = isset($row["temperature2"]) ? $row["temperature2"] : 0;
            $row_humidity1 = isset($row["humidity1"]) ? $row["humidity1"] : 0;
            $row_tempCelsius = isset($row["tempCelsius"]) ? $row["tempCelsius"] : 0;
            $row_pHvalue = isset($row["pHvalue"]) ? $row["pHvalue"] : 0;
            $row_conductivity = isset($row["conductivity"]) ? $row["conductivity"] : 0;
        
            // Check if the values are numeric before adding them to the sum
            if (is_numeric($row_temperature)) {
                $sumTemperature += $row_temperature;
            }
            if (is_numeric($row_humidity)) {
                $sumHumidity += $row_humidity;
            }
            if (is_numeric($row_temperature1)) {
                $sumTemperature1 += $row_temperature1;
            }
            if (is_numeric($row_temperature2)) {
                $sumTemperature2 += $row_temperature2;
            }
            if (is_numeric($row_humidity1)) {
                $sumHumidity1 += $row_humidity1;
            }
            if (is_numeric($row_tempCelsius)) {
                $sumTempCelsius += $row_tempCelsius;
            }
            if (is_numeric($row_pHvalue)) {
                $sumPHvalue += $row_pHvalue;
            }
            if (is_numeric($row_conductivity)) {
                $sumConductivity += $row_conductivity;
            }
            
            $rowCount++;
        }
        
    }

    // Calculate averages
    $avgTemperature = $sumTemperature / $rowCount;
    $avgHumidity = $sumHumidity / $rowCount;
    $avgTemperature1 = $sumTemperature1 / $rowCount;
    $avgHumidity1 = $sumHumidity1 / $rowCount;
    $avgTemperature2 = $sumTemperature2 / $rowCount;
    $avgTempCelsius = $sumTempCelsius / $rowCount;
    $avgPHvalue = $sumPHvalue / $rowCount;
    $avgConductivity = $sumConductivity / $rowCount;
} else {
    // Handle query error
    die("Error executing query: " . $conn->error);
}

$conn->close();
?>

<div class="col-sm-12 col-md-10" style="margin-top: 30px; left: 190px;">
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
                            { label: "Temperature Right", y: <?php echo $avgTemperature; ?> },
                            { label: "Temperature Left", y: <?php echo $avgTemperature2; ?> },
                            { label: "Humidity", y: <?php echo $avgHumidity; ?> },
                            { label: "Temperature Outside", y: <?php echo $avgTemperature1; ?> },
                            { label: "Humidity Outside", y: <?php echo $avgHumidity1; ?> },
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
    <div class="col-sm-12 col-md-10" style="left: 20px;">

        <div class="boxes">
        <div class="box box1">
                <i class="uil uil-temperature"></i>
                <span class="text">Temperature</span>
                <span class="text">Inside Left</span>
                <span class="number"><?php echo $row_temperature2; ?></span>
            </div>
            <div class="box box1">
                <i class="uil uil-temperature"></i>
                <span class="text">Temperature</span>
                <span class="text">Inside Right</span>
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

        <div class="container" style="height: 320px; width: 200%;">
        <div id="chartContainer" style="height: 320px; padding-right: 10px; width: 70%; margin-bottom: 20px;"></div>
<!-- Normal and Above Normal Sensors Table -->
<table id="normal-above-normal-sensors" style="height: 170px; padding-left: 100px; width:80%; margin-left: 10px; margin-bottom: 20px;padding padding-right: 90px">
    <tr>
        <th>Sensor</th>
        <th>Status</th>
        <th>Connectivity</th>
    </tr>
    <tr>
        
    <td>Temperature Left</td>
        <?php
        if (is_numeric($row_temperature2)) {
            $temperature2Status = ($row_temperature2 == 0) ? 'Below Normal' : ($row_temperature2 > 45 ? 'Above Normal' : 'Normal');
            $temperature2Class = ($row_temperature2 == 0) ? 'below-normal-label' : ($row_temperature2 > 45 ? 'above-normal-label' : 'normal-label');
        } else {
            // Handle NaN or non-numeric values as "Not Normal"
            $temperature2Status = 'Not Normal';
            $temperature2Class = 'not-normal-label';
        }
        ?>
        <td class="<?php echo $temperatur2eClass; ?>">
            <?php echo $temperature2Status; ?>
        </td>
        <td class="<?php echo $status_temperature2; ?>">
            <?php echo $status_temperature2; ?>
        </td>
        </tr>
    <tr>

    <td>Temperature Right</td>
        <?php
        if (is_numeric($row_temperature)) {
            $temperatureStatus = ($row_temperature == 0) ? 'Below Normal' : ($row_temperature > 35 ? 'Above Normal' : 'Normal');
            $temperatureClass = ($row_temperature == 0) ? 'below-normal-label' : ($row_temperature > 35 ? 'above-normal-label' : 'normal-label');
        } else {
            // Handle NaN or non-numeric values as "Not Normal"
            $temperatureStatus = 'Not Normal';
            $temperatureClass = 'not-normal-label';
        }
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
        if (is_numeric($row_humidity)) {
            $humidityStatus = ($row_humidity == 0) ? 'Below Normal' : ($row_humidity > 70 ? 'Above Normal' : 'Normal');
            $humidityClass = ($row_humidity == 0) ? 'below-normal-label' : ($row_humidity > 70 ? 'above-normal-label' : 'normal-label');
        } else {
            // Handle NaN or non-numeric values as "Not Normal"
            $humidityStatus = 'Not Normal';
            $humidityClass = 'not-normal-label';
        }
        ?>
        <td class="<?php echo $humidityClass; ?>">
            <?php echo $humidityStatus; ?>
        </td>
        <td class="<?php echo $status_humidity; ?>">
            <?php echo $status_humidity; ?>
        </td>
        </tr>
    <tr>
        <td>Temperature Outside</td>
        <?php
        if (is_numeric($row_temperature1)) {
            $temperature1Status = ($row_temperature1 == 0) ? 'Below Normal' : ($row_temperature1 > 45 ? 'Above Normal' : 'Normal');
            $temperature1Class = ($row_temperature1 == 0) ? 'below-normal-label' : ($row_temperature1 > 45 ? 'above-normal-label' : 'normal-label');
        } else {
            // Handle NaN or non-numeric values as "Not Normal"
            $temperature1Status = 'Not Normal';
            $temperature1Class = 'not-normal-label';
        }
        ?>
        <td class="<?php echo $temperatur1eClass; ?>">
            <?php echo $temperature1Status; ?>
        </td>
        <td class="<?php echo $status_temperature1; ?>">
            <?php echo $status_temperature1; ?>
        </td>
        </tr>
    <tr>

        <td>Humidity1</td>
        <?php
        if (is_numeric($row_humidity1)) {
            $humidity1Status = ($row_humidity1 == 0) ? 'Below Normal' : ($row_humidity1 > 90 ? 'Above Normal' : 'Normal');
            $humidity1Class = ($row_humidity1 == 0) ? 'below-normal-label' : ($row_humidity1 > 90 ? 'above-normal-label' : 'normal-label');
        } else {
            // Handle NaN or non-numeric values as "Not Normal"
            $humidity1Status = 'Not Normal';
            $humidity1Class = 'not-normal-label';
        }
        ?>
        <td class="<?php echo $humidity1Class; ?>">
            <?php echo $humidity1Status; ?>
        </td>
        <td class="<?php echo $status_humidity1; ?>">
            <?php echo $status_humidity1; ?>
        </td>
        </tr>
        <td>Water Temperature</td>
        <?php
        $tempCelsiusStatus = ($row_tempCelsius == 0) ? 'Below Normal' : ($row_tempCelsius > 35 ? 'Above Normal' : 'Normal');
        $tempCelsiusClass = ($row_tempCelsius == 0) ? 'below-normal-label' : ($row_tempCelsius > 35 ? 'above-normal-label' : 'normal-label');
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
$pHValueStatus = ($row_pHvalue == 0) ? 'Below Normal' : (($row_pHvalue < 5 || $row_pHvalue > 14) ? 'Outside Normal' : 'Normal');
$pHValueClass = ($row_pHvalue == 0) ? 'below-normal-label' : (($row_pHvalue < 5 || $row_pHvalue > 14) ? 'above-normal-label' : 'normal-label');
?>
<td class="<?php echo $pHValueClass; ?>">
    <?php echo $pHValueStatus; ?>
</td>
<td class="<?php echo $status_pHvalue; ?>">
    <?php echo $status_pHvalue; ?>
</td>
</tr>
    <tr>
    <td>Water Conductivity</td>
<?php
if (is_numeric($row_conductivity)) {
    if ($row_conductivity == 0) {
        $conductivityStatus = 'Normal';
        $conductivityClass = 'normal-label';
    } elseif ($row_conductivity < 0.04 || $row_conductivity > 1.00) {
        $conductivityStatus = 'Above Normal';
        $conductivityClass = 'above-normal-label';
    } else {
        $conductivityStatus = 'Normal';
        $conductivityClass = 'normal-label';
    }
} else {
    // Handle NaN or non-numeric values as "Not Normal"
    $conductivityStatus = 'Not Normal';
    $conductivityClass = 'not-normal-label';
}

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
