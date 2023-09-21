<?php
$msg = "";
define('TITLE', 'Cloud');
define('PAGE', 'Cloud');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if($_SESSION['is_login']){
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'</script>";
}
?>
<?php
include('includes/footer.php');
?>

<div class="col-sm-9 col-md-10" style="margin-top: 50px;">
</div>