<?php
require_once "../config/config.php";

function getAllUploads(){
	//Create array to store uploads data
	$uploads = array();

	//Query database for uploads data
	$query = "SELECT id, created_at, group_name, location, img_name, checked FROM uploads";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//If 1 or more uploads return, run fetch loop
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			//Push $row to uploads array
			$uploads[] = $row;
		}
	}
	return $uploads;
}
?>
