<?php 
define('TITLE', 'Dashboard');
define('PAGE', 'dashboard');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
    $aEmail = $_SESSION['aEmail'];
} else {
    echo "<script> location.href='login.php'</script>";
}


$sql = "SELECT COUNT(*) AS total_users FROM requesterlogin_tb";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalusers = $row['total_users'];

$sql = "SELECT COUNT(*) AS total_blocked FROM requesterlogin_tb WHERE is_blocked = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalblocked = $row['total_blocked'];

$sql = "SELECT COUNT(*) AS total_not_accepted FROM requesterlogin_tb WHERE is_accepted = 0 OR is_verified = 0";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalnotaccepted = $row['total_not_accepted'];
?>
<div class="col-sm-9 col-md-10">   <!-- Start Dashboard  2nd Column -->
    <div class="row text-center mx-5">
        <div class="col-sm-4 mt-5">
            <div class="card text-white bg-danger mb-3" style="max-width:18rem;">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $totalusers; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="card text-white bg-warning mb-3" style="max-width:18rem;">
                <div class="card-header">Total Blocked Accounts</div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $totalblocked; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-5">
            <div class="card text-white bg-info mb-3" style="max-width:18rem;">
                <div class="card-header">Requests </div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $totalnotaccepted; ?></h4>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-5 mt-5 text-center">
        <p class="bg-dark text-white p-2">Recent Users</p>
        <?php 
        $sql = "SELECT * FROM requesterlogin_tb";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo '
            <table class="table">
            <thead>
            <tr>
            <th scope="col">Requester ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            </tr>
            </thead>
            <tbody>';
            while($row = $result->fetch_assoc()){
            echo '<tr>';
             echo '<td>'.$row["r_login_id"].'</td>';
             echo '<td>'.$row["r_name"].'</td>';
             echo '<td>'.$row["r_email"].'</td>';
             echo '</tr>';
            }
            echo '</tbody>
            </table>';
        } else {
            echo '0 Result';
        }
        ?>
    </div>
    </div>
    </div>   <!-- End Dashboard 2nd Column -->
<?php include('includes/footer.php')?>