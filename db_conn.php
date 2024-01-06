<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;



// Firebase Realtime Database setup
$factory = (new Factory())
    ->withProjectId('agrictu')
    ->withServiceAccount('agrictu-firebase-adminsdk-w0xmc-32cdb8910b.json')
    ->withDatabaseUri('https://agrictu-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();

// MySQL Database connection setup
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "datalogdb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}
