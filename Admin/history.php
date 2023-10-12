<?php 
define('TITLE', 'Requester History');
define('PAGE', 'history');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
    $aEmail = $_SESSION['aEmail'];
} else {
    echo "<script> location.href='login.php'</script>";
}


// Handle block and unblock actions
if(isset($_POST['block'])){
    $blockId = $_POST['id'];
    // Update the database to set is_blocked to 1
    $updateBlockSql = "UPDATE requesterlogin_tb SET is_blocked = 1 WHERE r_login_id = $blockId";
    if($conn->query($updateBlockSql) === TRUE){
        // Redirect to the same page after blocking
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo 'Unable to Block';
    }
}

if(isset($_POST['unblock'])){
    $unblockId = $_POST['id'];
    // Update the database to set is_blocked to 0
    $updateUnblockSql = "UPDATE requesterlogin_tb SET is_blocked = 0 WHERE r_login_id = $unblockId";
    if($conn->query($updateUnblockSql) === TRUE){
        // Redirect to the same page after unblocking
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo 'Unable to Unblock';
    }
}
?>
<div class="col-sm-12 col-md-10" style="margin-top: 30px; left: 230px;">

<p class="bg-dark text-white p-2 text-center">History</p>
    
    <table class="table">
        <thead>
            <tr>
                <th>Requester ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $historySql = "SELECT r_login_id, r_name, r_email, is_accepted, accepted_date, rejected_date, is_blocked FROM requesterlogin_tb";
            $historyResult = $conn->query($historySql);
            
            while ($row = $historyResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["r_login_id"] . '</td>';
                echo '<td>' . $row["r_name"] . '</td>';
                echo '<td>' . $row["r_email"] . '</td>';
                echo '<td>' . ($row["is_accepted"] ? 'Accepted' : 'Rejected') . '</td>';
                echo '<td>' . ($row["is_accepted"] ? $row["accepted_date"] : $row["rejected_date"]) . '</td>';
                echo '<td>';
                if ($row["is_blocked"]) {
                    echo '<form action="" method="post" class="d-inline">';
                    echo '<input type="hidden" name="id" value='.$row["r_login_id"].'>';
                    echo '<button type="submit" class="btn btn-success" name="unblock" value="Unblock">Unblock</button>';
                    echo '</form>';
                } else {
                    echo '<form action="" method="post" class="d-inline">';
                    echo '<input type="hidden" name="id" value='.$row["r_login_id"].'>';
                    echo '<button type="submit" class="btn btn-danger" name="block" value="Block">Block</button>';
                    echo '</form>';
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Include your JavaScript and footer -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
