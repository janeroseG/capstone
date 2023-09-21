
<?php
define('TITLE', 'Accepted List');
define('PAGE', 'accepted');
include('includes/header.php');
include('../dbConnection.php');

session_start();
if(isset($_SESSION['is_adminlogin'])){
    $aEmail = $_SESSION['aEmail'];
} else {
    echo "<script> location.href='login.php'</script>";
}
?>
<meta http-equiv="refresh" content="60"> 

<div class="col-sm-9 col-md-10 mt-5 text-center">
<p class="bg-dark text-white p-2">List of Users</p>
    
    <?php
    $sql = "SELECT * FROM requesterlogin_tb WHERE is_accepted = 1";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Requester ID</th>';
        echo '<th scope="col">Name</th>';
        echo '<th scope="col">Email</th>';
        echo '<th scope="col">Role</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["r_login_id"] . '</td>';
            echo '<td>' . $row["r_name"] . '</td>';
            echo '<td>' . $row["r_email"] . '</td>';
            echo '<td>' . $row["role"] . '</td>';
            echo '</tr>';
        }
        
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'No accepted requesters found.';
    }
    ?>
</div>

<!-- Include your JavaScript and footer -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
