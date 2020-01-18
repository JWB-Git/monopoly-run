<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API Files
require_once "../api/user-data.php";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	if(!isAdmin($_SESSION['username'])){
		header("location: settings.php?action=error");
	}

	$query="UPDATE users SET admin = 1 WHERE id = '$id'";
	mysqli_query($link, $query);
	if($query){
		header("location: settings.php?action=admin-set-successfully");
	}
	else{
		header("location: settings.php?action=error");
	}
}

?>


