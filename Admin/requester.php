<?php 
define('TITLE', 'Requester');
define('PAGE', 'requesters');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if(isset($_SESSION['is_adminlogin'])){
    $aEmail = $_SESSION['aEmail'];
} else {
    echo "<script> location.href='login.php'</script>";
}
?>

<div class="col-sm-9 col-md-10 mt-5 text-center">
<p class="bg-dark text-white p-2">List of Requesters</p>
<?php 
$sql = "SELECT * FROM requesterlogin_tb"; 
$result = $conn->query($sql);
if($result->num_rows > 0){
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th scope="col">Requester ID</th>';
    echo '<th scope="col">Name</th>';
    echo '<th scope="col">Email</th>';
    echo '<th scope="col">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    
    while($row = $result->fetch_assoc()){
        if ($row["is_accepted"] == 1) {
            // Skip rows that are already accepted
            continue;
        }
        
        echo '<tr>';
        echo '<td>'.$row["r_login_id"].'</td>';
        echo '<td>'.$row["r_name"].'</td>';
        echo '<td>'.$row["r_email"].'</td>';
        echo '<td>';
        
        // Check if the request is accepted or rejected
        if ($row["is_accepted"] == 0) {
            echo '<form action="" method="POST" class="d-inline">';
            echo '<input type="hidden" name="id" value='.$row["r_login_id"].'>';
            echo '<input type="hidden" name="name" value="'.$row["r_name"].'">';
            echo '<input type="hidden" name="email" value="'.$row["r_email"].'">';
            echo '<button type="submit" class="btn btn-success mr-3" name="accept" value="Accept"><i class="fas fa-check"></i></button>';
            echo '</form>';
        }
        
        echo '<form action=""  method="POST" class="d-inline">';
        echo '<input type="hidden" name="id" value='.$row["r_login_id"].'>';
        echo '<button type="submit" class="btn btn-secondary mr-3" name="delete" value="Delete"><i class="fas fa-trash-alt"></i></button>';
        echo '</form>';
        
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '0 Result';
}

// Handle accept and delete actions
// Handle accept and delete actions
if(isset($_REQUEST['accept'])){
    $acceptedId = $_REQUEST['id'];
    // Update the database to set is_accepted to 1 and accepted_date to current datetime
    $updateSql = "UPDATE requesterlogin_tb SET is_accepted = 1, accepted_date = NOW() WHERE r_login_id = $acceptedId";
    if($conn->query($updateSql) === TRUE){
        // Remove the accepted row from the displayed table
        echo '<script>';
        echo 'var rowToRemove = document.querySelector("input[name=\'id\'][value=\''.$acceptedId.'\']").parentNode.parentNode;';
        echo 'rowToRemove.parentNode.removeChild(rowToRemove);';
        echo '</script>';
    } else {
        echo 'Unable to Accept';
    }
}

if(isset($_REQUEST['delete'])){
    $deletedId = $_REQUEST['id'];
    // Delete from the database
    $deleteSql = "DELETE FROM requesterlogin_tb WHERE r_login_id = $deletedId";
    if($conn->query($deleteSql) === TRUE){
        echo '<meta http-equiv="refresh" content= "0;URL=?deleted"/>';
    } else {
        echo 'Unable to Delete';
    }
}
?>

</div>

<!-- JavaScript and footer -->
<script src="../js/jquery.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/all.min.js"></script>
</body>
</html>
