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

<div class="col-sm-12 col-md-10" style="margin-top: 30px; left: 230px;">
    <!-- Start User Change Pasword  Form 2nd Column -->
    
    <nav class="navbar navbar-dark fixed-top bg-success flex-md-nowrap p-0 ">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 logo" href="Dashboard.php">
      <img src="../images/Untitled design (2).png" alt="Logo" style="height: 70px; width: 80px; padding-bottom:1px; margin-left:50px">
    </a>
    <form method="post" action="export_csv.php" onsubmit="return validateForm()">
        <div class="input-group width:00px margin-right:10px">
            <input type="date" name="selected_date" id="selected_date" class="form-control">
            <div class="input-group-append">
                <button type="submit" name="export" class="btn btn-primary">Export</button>
</div>
    </div>
</form>
</nav>
<script>
     
     function validateForm() {
    // Get the selected date value
    var selectedDate = document.getElementById("selected_date").value;

    // Check if the date is empty
if (selectedDate === "") {
    // Display notification banner for empty date
    // (No need to check for existingBanner here)
    var banner = document.createElement("div");
    banner.id = "errorBanner";
    banner.textContent = alert("Please select a date.");

    // Insert the banner before the form
    var form = document.querySelector("form");
    form.parentNode.insertBefore(banner, form);

    // Set a timeout to remove the banner after 5 seconds (5000 milliseconds)
    setTimeout(function () {
        banner.style.transition = "opacity 1s ease-in-out";
        banner.style.opacity = "0";
        setTimeout(function () {
            banner.remove();
        }, 1000); // After the fade-out, remove the banner from the DOM
    }, 5000); // Display the banner for 5 seconds (5000 milliseconds)

    // Prevent form submission
    return false;
} else {
    // Use AJAX to check data availability
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_data_availability.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText === "data_available") {
                // Data is available, allow form submission
                document.getElementById("errorBanner").remove();
                return true;
            } else if (xhr.responseText === "no_data_available") {
                // No data available, display alert
                var existingDataBanner = document.getElementById("noDataBanner");
                if (!existingDataBanner) {
                    var dataBanner = document.createElement("div");
                    dataBanner.id = "noDataBanner";
                    dataBanner.textContent = alert("No data available for the selected date.");

                    // Insert the banner before the form
                    var form = document.querySelector("form");
                    form.parentNode.insertBefore(dataBanner, form);

                    // Set a timeout to remove the banner after 5 seconds (5000 milliseconds)
                    setTimeout(function () {
                        dataBanner.style.transition = "opacity 1s ease-in-out";
                        dataBanner.style.opacity = "0";
                        setTimeout(function () {
                            dataBanner.remove();
                        }, 1000); // After the fade-out, remove the banner from the DOM
                    }, 5000); // Display the banner for 5 seconds (5000 milliseconds)

                    // Prevent form submission
                    return false;
                }
            }
        }
    };
    xhr.send("selected_date=" + selectedDate);
}
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
        $row_counter = 0; // Initialize a row counter
    
        while ($row = $result->fetch_assoc()) {
            if ($row_counter >= 12) {
                break; // Exit the loop after displaying 6 rows
            }
    
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
    
            $row_counter++; // Increment the row counter
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

    <?php
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $startPage + 4);

    for ($i = $startPage; $i <= $endPage; $i++) :
        if ($i == $currentPage) :
    ?>
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
