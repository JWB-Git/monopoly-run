<?php
require_once "../config/config.php";

function isAdmin($username){
	$query = "SELECT admin FROM users WHERE username='".$_SESSION['username']."'";

	global $link;
	$result = mysqli_query($link, $query);

	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			if($row['admin'] == 1){
				return true;
			}
			else{
				return false;
			}
		}
	}
	else{
		return false;
	}
}

function getAllUsers(){
	//Create array to store users data
	$users = array();

	//Query database for uploads data
	$query = "SELECT * FROM users";;

	//Execute Query
	global $link;
	$result = mysqli_query($link, $query);

	//If 1 or more uploads return, run fetch loop
	if(mysqli_num_rows($result) >= 1){
		while($row = mysqli_fetch_array($result)){
			//Push $row to uploads array
			$users[] = $row;
		}
	}
	return $users;
}
?>
