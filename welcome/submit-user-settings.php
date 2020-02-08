<?php
require_once "validuser.php";

//Required api's
require_once "../api/encryption.php";
require_once "../api/section-data.php";


if(isset($_POST["submit"]) && isset($_POST['email']) && isset($_POST['password'])){
	$section_pass = getSection($_SESSION['username'])['password'];

	$email = htmlspecialchars($_POST['email']);
	$password = simple_crypt(htmlspecialchars($_POST['password']), $section_pass, "e");

    $query = "UPDATE sections SET osm_email='".$email."', osm_password='".$password."' WHERE section_name = '".$_SESSION['username']."'";

	global $link;
	$result = mysqli_query($link, $query);

	if($result){
		$_SESSION['osm_secret'] = "";
		$_SESSION['osm_user_id'] = "";

		header("location: index.php?action=osm-details-updated");
	}
	else{
		header("location: index.php?action=error");
	}
}
else{
    header("location: index.php?action=error");
}
?>
