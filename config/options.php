<?php
$options = array(
	"name" => "Newcastle Monopoly Run",
	"hq_number" => "000000000",

	//If OSM Integration is active (1), display extra pages.
	"osm_integration" => 0,

	"map_settings" => array(
		//Centre of Map Latitude and Longitude
		"centre_lat" => 55.0056,
		"centre_lng" => -1.534,

		//Map Zoom Level
		"zoom" => 12
	),

	"time_settings" => array(
		"timestamp_divisor" => 60, //Divide timestamp by 60 to get minutes
		"game_length" => 360, //Number of minutes teams have in the game
		"points_minute" => 10 //Number of points lost for every minute the teams are late back
	)
);
?>
