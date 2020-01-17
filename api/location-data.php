<?php
require_once "../config/config.php";

function getAllLocations(){
	//Create array to store locations data
	$locations = array();

	//Query database for uploads data
	$query = "SELECT id, name, colour, value, q_bonus FROM spaces";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//If 1 or more uploads return, run fetch loop
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			//Push $row to uploads array
			$locations[] = $row;
		}
	}
	return $locations;
}

function getLocationValues($location){
	$query = "SELECT value, q_bonus FROM spaces WHERE name='".$location."'";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//Check for 1 result
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			//Return Location Value Data
			return $row;
		}
	}
}
?>
