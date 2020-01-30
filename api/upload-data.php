<?php
require_once "../config/config.php";

function getAllUploads(){
	//Create array to store uploads data
	$uploads = array();

	//Query database for uploads data
	$query = "SELECT id, created_at, group_name, location, img_name, checked, question_correct FROM uploads";

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

function getUploadsByCheckedStatus($checkedStatus){
	//Create array to store uploads data
	$uploads = array();

	//Query database for uploads data (with specific checked status)
	$query = "SELECT id, created_at, group_name, location, img_name FROM uploads WHERE checked='".$checkedStatus."'";

	//Execute query
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

function getUpload($id){
	$query = "SELECT group_name, location, img_name, answer FROM uploads WHERE id='".$id."'";

	global $link;
	$result = mysqli_query($link, $query);

	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			return $row;
		}
	}
}

function getGroupCheckedUploads($group_name){
	//Create array to store uploads data
	$uploads = array();

	//Query database for uploads data
	$query = "SELECT * FROM uploads WHERE group_name='".$group_name."' AND checked = 1";

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

function getUploadStatuses($group_name, $location){
	$query = "SELECT checked, question_correct FROM uploads WHERE group_name = '".$group_name."' AND location = '".$location."'";

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//If 1 or more rows return, return the 1st row
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			$checked_icon = "";
			$question_icon = "";

			switch($row['checked']){
				case 0:
					$checked_icon = "text-warning fas fa-minus-circle";
					break;
				case 1:
					$checked_icon = "text-success fas fa-check-circle";
					break;
				case 2:
					$checked_icon = "text-danger fas fa-times-circle";
					break;
				default:
					$checked_icon = "text-danger fas fa-exclamation-circle";
					break;
			}

			switch($row['question_correct']){
				case 0:
					if($row['checked'] == 0){
						$question_icon = "text-warning fas fa-minus-circle";
					}
					else{
						$question_icon = "text-danger fas fa-times-circle";
					}
					break;
				case 1:
					$question_icon = "text-success fas fa-check-circle";
					break;
				case 2:
					$question_icon = "text-danger fas fa-times-circle";
					break;
				default:
					$question_icon = "text-danger fas fa-exclamation-circle";
					break;
			}

			return array(
				'checked_icon' => $checked_icon,
				'question_icon' => $question_icon);
		}
	}
	else{
		return array(
			'checked_icon' => 'fas fa-arrow-circle-up',
			'question_icon' => 'fas fa-arrow-circle-up');
	}
}
?>
