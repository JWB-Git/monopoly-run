<?php
require_once "validuser.php";

if(isset($_POST["mark-as-correct"])) {
	$id = $_POST['id'];
	$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);

	$query = "UPDATE uploads SET checked = 1, question_correct = 1, comment = '".$comment."' WHERE id = '".$id."'";
	$result = mysqli_query($link, $query);

	if($result){
		header("location: index.php?action=submission-updated-successfully");
	}
	else{
		header("location: index.php?action=error");
	}
}
else if(isset($_POST["mark-as-semi-correct"])) {
	$id = $_POST['id'];
	$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);

	$query = "UPDATE uploads SET checked = 1, comment = '".$comment."' WHERE id = '".$id."'";
	$result = mysqli_query($link, $query);

	if($result){
		header("location: index.php?action=submission-updated-successfully");
	}
	else{
		header("location: index.php?action=error");
	}
}
else if(isset($_POST["mark-as-wrong"])) {
	$id = $_POST['id'];
	$comment = htmlspecialchars($_POST['comment'], ENT_QUOTES);

	$query = "UPDATE uploads SET checked = 2, comment = '".$comment."' WHERE id = '".$id."'";
	$result = mysqli_query($link, $query);

	if($result){
		header("location: index.php?action=submission-updated-successfully");
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
	header("location: index.php");
}
?>
