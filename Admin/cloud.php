
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
<div class="col-sm-12 col-md-10" style="margin-top: 30px; left: 230px;">
<p class="bg-dark text-white p-2 text-center">Connect to Cloud</p>


<p class="text-black p-2 text-center">Click thingspeak to connect to cloud</p>

<br/>
<div class="container">
    <a href="https://thingspeak.com/channels/2394171" target="_blank">
       <img src="../images/cloud.png" />
    </a>
</div>

</div>
<style>
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 10vh; 
    }
    </style>