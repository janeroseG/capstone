<?php
$msg = "";
define('TITLE', 'latestreading');
define('PAGE', 'latestreading');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if ($_SESSION['is_login']) {
    $rEmail = $_SESSION['rEmail'];
} else{
    echo "<script> location.href='login.php'</script>";
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "datalogdbs";
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
$sqlCount = "SELECT COUNT(*) AS total FROM  sensordatas";
$resultCount = $conn->query($sqlCount);
if ($resultCount) {
    $row = $resultCount->fetch_assoc();
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);
}

// Retrieve data with OFFSET and LIMIT for pagination
$sqlData = "SELECT id, location, temperature, humidity, temperature1, humidity1, tempCelsius, pHvalue, conductivity, reading_time FROM  sensordatas ORDER BY id DESC LIMIT $offset, $recordsPerPage";

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
        $row_tempCelsius = $row["tempCelsius"];
        $row_pHvalue = $row["pHvalue"];
        $row_conductivity = $row["conductivity"];

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

<div class="col-sm-9 col-md-10" style="margin-top: 40px;">
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

        <br><br>
        <div class="container">
        <div id="chartContainer" style="height: 370px; width: 50%; padding-right: 10px; margin-bottom: 20px;"></div>
<table id="tables" style="height: 370px; width: 50%; padding-left: 30px; padding-right: 10px; margin-left: 20px;">
    <tr>
        <th>Sensor</th>
        <th>Status</th>
    </tr>
    <tr>
        <td>Temperature</td>
        <td class="<?php echo ($row_temperature <= 25) ? 'active-label' : 'inactive-label'; ?>"><?php echo ($row_temperature <= 25) ? 'Normal' : 'Above Normal'; ?></td>
    </tr>
    <tr>
        <td>Humidity</td>
        <td class="<?php echo ($row_humidity <= 50) ? 'active-label' : 'inactive-label'; ?>"><?php echo ($row_humidity <= 50) ? 'Normal' : 'Above Normal'; ?></td>
    </tr>
    <tr>
        <td>Temperature1</td>
        <td class="<?php echo ($row_temperature1 <= 30) ? 'active-label' : 'inactive-label'; ?>"><?php echo ($row_temperature1 <= 30) ? 'Normal' : 'Above Normal'; ?></td>
    </tr>
    <tr>
        <td>Humidity1</td>
        <td class="<?php echo ($row_humidity1 <= 60) ? 'active-label' : 'inactive-label'; ?>"><?php echo ($row_humidity1 <= 60) ? 'Normal' : 'Above Normal'; ?></td>
    </tr>
    <tr>
        <td>Temp Celsius</td>
        <td class="<?php echo ($row_tempCelsius <= 25) ? 'active-label' : 'inactive-label'; ?>"><?php echo ($row_tempCelsius <= 25) ? 'Normal' : 'Above Normal'; ?></td>
    </tr>
    <tr>
        <td>pH Value</td>
        <td class="<?php echo ($row_pHvalue < 5) ? 'inactive-label' : (($row_pHvalue >= 5 && $row_pHvalue <= 8) ? 'active-label' : 'inactive-label'); ?>">
    <?php echo ($row_pHvalue < 5) ? 'Below Normal' : (($row_pHvalue >= 5 && $row_pHvalue <= 8) ? 'Normal' : 'Above Normal'); ?>
</td>

    </tr>
    <tr>
        <td>Conductivity</td>
        <td class="<?php echo ($row_conductivity >= 0.04 && $row_conductivity <= 1.00) ? 'active-label' : 'inactive-label'; ?>">
    <?php echo ($row_conductivity >= 0.04 && $row_conductivity <= 1.00) ? 'Normal' : 'Above Normal'; ?>
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
