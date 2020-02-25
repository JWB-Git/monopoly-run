<?php
require_once "../config/config.php";

include "../config/options.php";

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
	$query = "SELECT * FROM groups WHERE id='".$id."'";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//Check for 1 result
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			//Return Group
			return $row;
		}
	}
}

function checkInOut($group){
	$query = "SELECT check_in, check_out FROM groups WHERE group_name='".$group."'";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//Check for 1 result
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			//Return Group
			return $row;
		}
	}
}

function getGroupPoints($id){
	//Get Group Info
	$group = getGroup($id);

	$points_deduct = getPointsDeduct($group['group_name']);

	$points = -$points_deduct; //Start counting points on amount of points deducted


	//Required to count amount of each set a group has gone to.
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

function getPointsDeduct($group){
	/** Important Constants **/
	global $options;
	$TIMESTAMP_DIVISOR = $options['time_settings']['timestamp_divisor']; //Divide timestamp by 60 to get minutes
	$GAME_LENGTH = $options['time_settings']['game_length']; //Number of minutes teams have in the game
	$POINTS_MINUTE = $options['time_settings']['points_minute']; //Number of points lost for every minute the teams are late back

	$check_in_out = checkInOut($group);

	if($check_in_out['check_out'] == "0000-00-00 00:00:00"){
		return 0;
	}
	else{
		$total_time = intval((strtotime($check_in_out['check_out']) - strtotime($check_in_out['check_in'])) / $TIMESTAMP_DIVISOR);

		$mins_late = ($total_time - $GAME_LENGTH > 0) ? $total_time - $GAME_LENGTH : 0; //Checks if team is actually late. If not, set late to 0 so that no points are added or deducted.

		return $mins_late * $POINTS_MINUTE;
	}
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

function timeRemaining($id){
	$group = getGroup($id);

	/** Important Constants **/
	global $options;
	$TIMESTAMP_DIVISOR = $options['time_settings']['timestamp_divisor']; //Divide timestamp by 60 to get minutes
	$GAME_LENGTH = $options['time_settings']['game_length']; //Number of minutes teams have in the game
	$POINTS_MINUTE = $options['time_settings']['points_minute']; //Number of points lost for every minute the teams are late back

	$start_time = $group['check_in'];
	$current_time = date('Y-m-d H:i:s');
	$time_taken = intval(strtotime($current_time) - strtotime($start_time));

	$time_remaining = ($GAME_LENGTH - $time_taken/$TIMESTAMP_DIVISOR);

	if($group['check_in'] == "0000-00-00 00:00:00"){
		return 'Team Not Out';
	}
	if($group['check_out'] != "0000-00-00 00:00:00"){
		return 'Team Back In';
	}
	if($time_remaining < 0){
		return 'Team Late!';
	}
	else{
		$hours = intval($time_remaining / 60);
		$minutes = intval($time_remaining % 60);
		if($minutes < 10){
			$minutes = '0'.$minutes;
		}
		return $hours.":".$minutes;
	}
}
?>
