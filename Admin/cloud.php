
<?php
define('TITLE', 'Connect Cloud');
define('PAGE', 'cloud');
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
