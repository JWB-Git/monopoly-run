<?php
require_once "validuser.php";

//Required api's
require_once "../api/encryption.php";
require_once "../api/section-data.php";


if(isset($_POST["submit"]) && isset($_POST['section-id'])){
	$section_id = $_POST['section-id'];

    $query = "UPDATE sections SET section_id='".$section_id."' WHERE section_name = '".$_SESSION['username']."'";

	global $link;
	$result = mysqli_query($link, $query);

	if($result){
		header("location: osm-set-ids.php?action=section-id-updated");
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
    header("location: index.php?action=error");
}
?>
