<?php
$db_host ="localhost";// default
$db_user ="root";// default
$db_password ="";// default
$db_name ="datalogdb";// name of yout database
$db_port = 3306;

// Create Connection

$conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

// depending on what is the variable you are using

// Checking Connection
if($conn->connect_error){
    die("Connection Failed");
} 
//else {
  //  echo"Connect";
// }

?>

