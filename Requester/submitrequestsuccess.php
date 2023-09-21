<?php
define('TITLE', 'Success');
define('PAGE', 'Submit Success');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if($_SESSION['is_login']){
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'</script>";
}
$sql = "SELECT * FROM  submitrequest_tb WHERE request_id = {$_SESSION['myid']}"; 
$result = $conn->query($sql);
if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    echo "<div class='ml-5 mt-5'>
    <table class='table'>
    <tbody>
    <tr>
        <th>Request ID</th>
        <td>".$row['request_id']."</td>
    </tr>
    <tr>
        <th>Name</th>
        <td>".$row['requester_name']."</td>
    </tr>
    <tr>
        <th>Laboratory Number</th>
        <td>".$row['requester_labnumb']."</td>
    </tr>

    <tr>
        <th>Email</th>
         <td>".$row['requester_email']."</td>
    </tr>
    <tr>
        <th>Mobile Number</th>
        <td>".$row['requester_mobile']."</td>
    </tr>

    <tr>
        <th>Type of Request</th>
        <td>".$row['request_info']."</td>
    </tr>
    
    <tr>
        <th>Request Description</th>
        <td>".$row['request_desc']."</td>
    </tr>
    <tr>
        <th>Request Date</th>
        <td>".$row['request_date']."</td>
    <tr>
        <td><form class='d-print-none'><input class='btn btn-danger' type='submit' value='Print' onClick='window.print()'></form></td>
    </tr>
    </tbody>
    </table> </div>
    ";
}   else {
    echo "Failed";
}
include('includes/footer.php');
?>