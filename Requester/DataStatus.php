<?php
define('TITLE', 'DataStatus');
define('PAGE', 'DataStatus');
include('../dbConnection.php');
include('includes/header.php');
session_start();
if ($_SESSION['is_login']) {
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php';</script>";
}
?>

<link rel="stylesheet" href="../css/table1.css">
<link rel="stylesheet" href="../css/page.css">
<div class="col-sm-9 col-md-10" style="margin-top: 30px;">
    <!-- Start User Change Pasword  Form 2nd Column -->
    
    <form method="post" action="export_csv.php" onsubmit="return validateForm()">
    <div class="form-group">
        <label for="selected_date">Select Date:</label>
        <div class="input-group">
            <input type="date" name="selected_date" id="selected_date" class="form-control">
            <div class="input-group-append">
                <button type="submit" name="export" class="btn btn-primary">Export to CSV</button>
            </div>
        </div>
    </div>
</form>
<script>
     
     function validateForm() {
    // Get the selected date value
    var selectedDate = document.getElementById("selected_date").value;

    // Check if the date is empty
    if (selectedDate === "") {
        // Check if the banner is already displayed
        var existingBanner = document.getElementById("errorBanner");
        if (!existingBanner) {
            // Display notification banner for empty date
            var banner = document.createElement("div");
            banner.id = "errorBanner";
            banner.style.backgroundColor = "#f44336";
            banner.style.color = "white";
            banner.style.textAlign = "center";
            banner.style.padding = "10px";
            banner.textContent = "Please select a date.";
            
            // Insert the banner before the form
            var form = document.querySelector("form");
            form.parentNode.insertBefore(banner, form);

            // Set a timeout to remove the banner after 5 seconds (5000 milliseconds)
            setTimeout(function() {
                banner.style.transition = "opacity 1s ease-in-out";
                banner.style.opacity = "0";
                setTimeout(function() {
                    banner.remove();
                }, 1000); // After the fade-out, remove the banner from the DOM
            }, 5000); // Display the banner for 5 seconds (5000 milliseconds)

            // Prevent form submission
            return false;
        }
    } else {
        // Check if there is no data for the selected date
        // You need to define your logic here to check if there is no data
        // For example, you can use AJAX to check on the server whether data exists for the selected date.
        // If no data exists, display an alert banner.
        // Here, I'll provide a basic example using a hardcoded condition.
        
        var noDataAvailable = true; // Set this variable based on your data availability check.
        
        if (noDataAvailable) {
            // Check if the banner is already displayed
            var existingDataBanner = document.getElementById("noDataBanner");
            if (!existingDataBanner) {
                // Display notification banner for no data
                var dataBanner = document.createElement("div");
                dataBanner.id = "noDataBanner";
                dataBanner.style.backgroundColor = "#f44336";
                dataBanner.style.color = "white";
                dataBanner.style.textAlign = "center";
                dataBanner.style.padding = "10px";
                dataBanner.textContent = "No data available for the selected date.";
                
                // Insert the banner before the form
                var form = document.querySelector("form");
                form.parentNode.insertBefore(dataBanner, form);

                // Set a timeout to remove the banner after 5 seconds (5000 milliseconds)
                setTimeout(function() {
                    dataBanner.style.transition = "opacity 1s ease-in-out";
                    dataBanner.style.opacity = "0";
                    setTimeout(function() {
                        dataBanner.remove();
                    }, 1000); // After the fade-out, remove the banner from the DOM
                }, 5000); // Display the banner for 5 seconds (5000 milliseconds)
            }
            
            // Prevent form submission
            return false;
        }
    }
    // Allow form submission if date is selected and data is available
    return true;
}

</script>


    <?php
    // Set the number of records to display per page
    $recordsPerPage = 12;

    // Get the current page number from the URL
    if (isset($_GET['page'])) {
        $currentPage = $_GET['page'];
    } else {
        $currentPage = 1;
    }

    // Calculate the OFFSET value for the SQL query
    $offset = ($currentPage - 1) * $recordsPerPage;
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

    $sql = "SELECT COUNT(*) AS total FROM  sensordata";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $totalRecords = $row['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    $sql = "SELECT id, location, temperature, humidity, temperature1, humidity1,tempCelsius,pHvalue,conductivity,reading_time FROM sensordata ORDER BY id DESC LIMIT $offset, $recordsPerPage";
 
 


    echo '<div class="table-container"><table cellspacing="5" cellpadding="5">
      <tr> 
        <th>Date &amp; Time</th> 
        <th>Temperature Outside &deg;C</th> 
        <th>Humidity Outside &#37;</th>
        <th>Temperature Inside &deg;C</th> 
        <th>Humidity1 Inside &#37;</th>
        <th>Water Temperature &deg;C</th>
        <th>PH level</th>
        <th>Water Conductivity</th>
      </tr>';

    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $row_reading_time = $row["reading_time"];
            $row_temperature = $row["temperature"];
            $row_humidity = $row["humidity"];
            $row_temperature1 = $row["temperature1"];
            $row_humidity1 = $row["humidity1"];
            $row_tempCelsius = $row["tempCelsius"];
            $row_pHvalue = $row["pHvalue"];
            $row_conductivity = $row["conductivity"];

            echo '<tr> 
               
                <td>' . $row_reading_time . '</td> 
                <td>' . $row_temperature . '</td> 
                <td>' . $row_humidity . '</td>
                <td>' . $row_temperature1 . '</td> 
                <td>' . $row_humidity1 . '</td> 
                <td>' . $row_tempCelsius . '</td> 
                <td>' . $row_pHvalue . '</td> 
                <td>' . $row_conductivity . '</td>  
              </tr>';
        }
        $result->free();
    }
    $conn->close();
    ?>
 </table>
 
</div> <!-- End User Change Pasword  Form 2nd Column -->


 
<div class="pagination">
<?php if ($currentPage > 1) : ?>
    <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
<?php endif; ?>

<?php for ($i = 1; $i <= $totalPages; $i++) : ?>
    <?php if ($i == $currentPage) : ?>
        <span class="current-page"><?php echo $i; ?></span>
    <?php else : ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endif; ?>
<?php endfor; ?>

<?php if ($currentPage < $totalPages) : ?>
    <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
<?php endif; ?>
</div>
<?php
include('includes/footer.php');
?>
