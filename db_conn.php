<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory())
    ->withProjectId('agrictu')
    ->withServiceAccount('agrictu-firebase-adminsdk-w0xmc-32cdb8910b.json')
    ->withDatabaseUri('https://agrictu-default-rtdb.firebaseio.com/');

	$database = $factory->createDatabase();

$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "datalogdb";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}