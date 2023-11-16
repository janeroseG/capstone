<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory())
    ->withProjectId('agrifresh-7573e')
    ->withDatabaseUri('https://agrifresh-7573e.firebaseio.com');

	$database = $factory->createDatabase();

$sname= "localhost";
$unmae= "root";
$password = "";

$db_name = "datalogdb";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}