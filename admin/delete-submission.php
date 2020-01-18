<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$query="DELETE FROM uploads WHERE id = '$id'";
	mysqli_query($link, $query);
	if($query){
		header("location: index.php?action=submission-deleted-successfully");
	}
	else{
		header("location: index.php?action=error");
	}
}

?>
