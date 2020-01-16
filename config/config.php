<?php
//Database Creds
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'monopoly_run');

//Attempt Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//Check Connection

if(!$link){
	die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
