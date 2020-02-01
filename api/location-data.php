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

function getLocation($id){
	$query = "SELECT name, colour, value, question, q_bonus FROM spaces WHERE id='".$id."'";

	global $link;
	$result = mysqli_query($link, $query);

	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			return $row;
		}
	}
}

function getLocationValues($location){
	$query = "SELECT colour, value, q_bonus, correct_ans, lat, lng FROM spaces WHERE name='".$location."'";

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

function getLocationColours(){
	$location_colours = array();

	$query = "SELECT * FROM space_colours";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//Check for 1 result
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			//Return Location Value Data
			$location_colours[] = $row;
		}
	}

	return $location_colours;
}
?>
