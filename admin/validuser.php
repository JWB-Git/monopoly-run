<?php
session_start();
include "../config/config.php";
$query="SELECT confirmed_user FROM users WHERE username='".$_SESSION['username']."'";
$result = mysqli_query($link, $query);
if(mysqli_num_rows($result) == 1){
	while($row = mysqli_fetch_array($result)){
		$confirmed = $row['confirmed_user'];
	}
}
//Check if user is logged on
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== "user"){
	header("location:login.php");
	exit;
}

if($confirmed == 0){
	header("location:logout.php");
}
?>
