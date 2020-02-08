<?php
require_once "../config/config.php";

function getSection($section_name){
	$query = "SELECT * FROM sections WHERE section_name='".$section_name."'";

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

?>
