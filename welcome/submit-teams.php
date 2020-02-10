<?php
require_once "validuser.php";

if(isset($_POST['json-string'])){
	$input_arr = json_decode($_POST['json-string'], true);

	//var_dump($input_arr);

	foreach($input_arr as $team){
		//var_dump($team);
		foreach($team['members'] as $members){
			var_dump($members);
		}
	}


}

?>
