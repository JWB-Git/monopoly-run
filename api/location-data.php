<?php
require_once "../config/config.php";

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
