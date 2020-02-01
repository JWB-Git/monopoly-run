<?php
require_once "../config/config.php";

//Other required apis
require_once "location-data.php";

function getAllGroups(){
	//Create array to store groups data
	$groups = array();

	//Query database for uploads data
	$query = "SELECT id, group_name FROM groups";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//If 1 or more uploads return, run fetch loop
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			//Push $row to uploads array
			$groups[] = $row;
		}
	}
	return $groups;
}

function getGroup($id){
	$query = "SELECT group_name, points_deduct FROM groups WHERE id='".$id."'";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//Check for 1 result
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			//Return Group Name
			return $row;
		}
	}
}

function getGroupPoints($id){
	//Get Group Info
	$group = getGroup($id);

	$points = -$group['points_deduct'];

	$set_count = array(
		"brown" => 0,
		"light-blue" => 0,
		"pink" => 0,
		"orange" => 0,
		"red" => 0,
		"yellow" => 0,
		"green" => 0,
		"blue" => 0,
		"chance" => 0,
		"chest" => 0
	);

	//Get all locations team has visited and been checked at
	$locationQuery = "SELECT location, question_correct FROM uploads WHERE group_name='".$group['group_name']."' AND checked=1";

	global $link;

	$locationResult = mysqli_query($link, $locationQuery);

	//If 1 or more location found, begin loop to get location values
	if(mysqli_num_rows($locationResult) >= 1){
		while($location = mysqli_fetch_array($locationResult)){
			//Fetch location values
			$values = getLocationValues($location['location']);

			//Add to team total
			$points += $values['value'];

			//Add colour to set count
			$set_count[$values['colour']] += 1;

			//Add question bonus if questionis correct
			if($location['question_correct'] == 1){
				$points += $values['q_bonus'];
			}
		}
	}

	$points += getSetBonusPoints($set_count);

	//Return Points
	return $points;
}

function getSetBonusPoints($set_count){
	$bonus_points = 0;

	foreach(getLocationColours() as $colour){
		if($colour['set_spaces'] == $set_count[$colour['colour']]){
			$bonus_points += $colour['set_bonus'];
		}
	}
	return $bonus_points;
}
?>
