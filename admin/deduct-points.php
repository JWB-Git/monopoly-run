<?php
require_once "validuser.php";

if(isset($_POST["submit"])){
	$points_deduct = $_POST['points_deduct'];
	if($points_deduct==null){
		$points_deduct=0;
	}

	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$query = "UPDATE groups SET points_deduct = '".$points_deduct."' WHERE id = '".$id."'";
		$result = mysqli_query($link, $query);

		if($result){
			header("location: index.php?action=points-deducted-successfully");
		}
		else{
			header("location: index.php?action=error");
		}
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
	header("location: index.php?action=error");
}
?>
