<?php
session_start();
include "../config/config.php";

//Check if user is logged on
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== "group"){
	header("location:login.php");
	exit;
}
?>
