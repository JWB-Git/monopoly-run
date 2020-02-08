<?php
//Required API's
require_once "section-data.php";

//OSM Base Information
$apiid = 324;
$token = 'f6b661c90e2e38bf4e84d7b5797f4007';

$base = 'https://www.onlinescoutmanager.co.uk/';

function osmSecretSet(){
	if($_SESSION["osm_secret"] == ""){
		return 0;
	}
	else{
		return 1;
	}
}

function authorise() {
	$section = getSection($_SESSION['username']);

	$parts['password'] = simple_crypt($section['osm_password'], $section['password'], "d");
	$parts['email'] = $section['osm_email'];
	return perform_query('users.php?action=authorise', $parts);
}

function perform_query($url, $parts) {
	global $apiid, $token, $base;

	$parts['token'] = $token;
	$parts['apiid'] = $apiid;

	if ($_SESSION['osm_user_id'] > 0) {
		$parts['userid'] = $_SESSION['osm_user_id'];
	}
	if (strlen($_SESSION['osm_secret']) == 32) {
		$parts['secret'] = $_SESSION['osm_secret'];
	}

	$data = '';
	foreach ($parts as $key => $val) {
		$data .= '&'.$key.'='.urlencode($val);
	}

	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $base.$url);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, substr($data, 1));
	curl_setopt($curl_handle, CURLOPT_POST, 1);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	$msg = curl_exec($curl_handle);
	return json_decode($msg, true);
}
?>
