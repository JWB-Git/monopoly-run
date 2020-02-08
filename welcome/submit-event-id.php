<?php
require_once "validuser.php";

//Required api's
require_once "../api/encryption.php";
require_once "../api/section-data.php";


if(isset($_POST["submit"]) && isset($_POST['event-id'])){
	$event_id = $_POST['event-id'];

    $query = "UPDATE sections SET event_id='".$event_id."' WHERE section_name = '".$_SESSION['username']."'";

	global $link;
	$result = mysqli_query($link, $query);

	if($result){
		header("location: index.php?action=event-id-updated");
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
    header("location: index.php?action=error");
}
?>
