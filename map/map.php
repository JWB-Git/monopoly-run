<?php
//Check if user is logged on and confirmed user
require_once "../config/config.php";

//Requires options code
require_once "../config/options.php";

//Check Group ID has been set
if(isset($_GET['group_name'])){
	$group_name = $_GET['group_name'];
}
else{
	header("location: https://cdn.shopify.com/s/files/1/1061/1924/products/Sad_Face_Emoji_large.png?v=1571606037");
}

//Require API Files
require_once "../api/upload-data.php";
require_once "../api/location-data.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Team Map</title>

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>

	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>

	<style>
		html, body{
			padding: 0;
			margin: 0;
		}
		#mapid{
			height: 750px;
			width: 100vw;
		}
	</style>
</head>

<body>
	<div id="mapid"></div>

	<script>
		//Markers
		var blueIcon = new L.Icon({
		  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
		  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
		  iconSize: [25, 41],
		  iconAnchor: [12, 41],
		  popupAnchor: [1, -34],
		  shadowSize: [41, 41]
		});
		var redIcon = new L.Icon({
		  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
		  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
		  iconSize: [25, 41],
		  iconAnchor: [12, 41],
		  popupAnchor: [1, -34],
		  shadowSize: [41, 41]
		});
		var greenIcon = new L.Icon({
		  iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
		  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
		  iconSize: [25, 41],
		  iconAnchor: [12, 41],
		  popupAnchor: [1, -34],
		  shadowSize: [41, 41]
		});


		//Set initial icon to red icon
		var icon = redIcon;

		var map = L.map('mapid').setView([<?php echo $options['map_settings']['centre_lat'] ?>, <?php echo $options['map_settings']['centre_lng'] ?>], <?php echo $options['map_settings']['zoom'] ?>);

		L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			maxZoom: 18,
    		id: 'mapbox/streets-v11',
    		accessToken: 'pk.eyJ1IjoiandiIiwiYSI6ImNqc3htb2JlMTBudmM0NHQzOTY1aXdha2kifQ.yBiRAb6OHWsJtrrzAw8QAQ'
		}).addTo(map);

		var lines=[];

		<?php
		$uploads = getGroupCheckedUploads($group_name);
		for($i = 0; $i < count($uploads); $i++){
			if($i+1 == count($uploads)){
				?>
				icon = greenIcon;
				<?php
			}

			//Get Lat Lng of Upload Location
			$location = getLocationValues($uploads[$i]['location']);
		?>

			var lat = <?php echo $location['lat'] ?>;
			var lng = <?php echo $location['lng'] ?>;

			//Push to Polyline
			lines.push([lat, lng]);

			//Add marker at said lat lng
			L.marker([lat, lng], {icon: icon}).addTo(map);

			//Set icon to blue
			icon = blueIcon;

		<?php
		//End of for loop
		}
		?>

		L.polyline(lines, {color: 'blue'}).addTo(map);
	</script>
</body>
</html>
