<?php
require_once "validuser.php";

//Required api's
require_once "../api/encryption.php";
require_once "../api/section-data.php";


if(isset($_POST["submit"]) && isset($_POST['term-id'])){
	$term_id = $_POST['term-id'];

    $query = "UPDATE sections SET term_id='".$term_id."' WHERE section_name = '".$_SESSION['username']."'";

	global $link;
	$result = mysqli_query($link, $query);

	if($result){
		header("location: osm-set-ids.php?action=term-id-updated");
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
    header("location: index.php?action=error");
}
?>
