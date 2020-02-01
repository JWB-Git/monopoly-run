<!-- This is the backend page for submitting a picture. For the frontend, see submit-picture.php -->

<?php
	//Check if user is logged on and confirmed user
	require_once "validuser.php";

	$name = ''; $type = ''; $size = ''; $error = '';
	function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($source_url);

    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($source_url);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($source_url);

    		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}

	if ($_POST) {

		$location = htmlspecialchars($_POST['location']);
		$group_name = htmlspecialchars($_POST['group']);
		$answer = htmlspecialchars($_POST['answer']);

		if ($_FILES["file"]["error"] > 0) {
				$error = $_FILES["file"]["error"];
		}
		else if (($_FILES["file"]["type"] == "image/gif") ||
		($_FILES["file"]["type"] == "image/jpeg") ||
		($_FILES["file"]["type"] == "image/png") ||
		($_FILES["file"]["type"] == "image/pjpeg")) {

			$url = '../uploads/'.basename($_FILES['file']['name']);

			$filename = compress_image($_FILES["file"]["tmp_name"], $url, 80);
			$buffer = file_get_contents($url);

			$query = "INSERT INTO uploads (group_name, location, answer, img_name) VALUES ('".$group_name."', '".$location."', '".$answer."', '".basename($_FILES["file"]["name"])."')";
			$result = mysqli_query($link, $query);

			if(!$result){
				header("location: index.php?action=database-update-error");
			}
			else{
				header("location: index.php?action=upload-successful");
			}

		}
		else{
			$error = "Uploaded image should be jpg or gif or png";
		}
	}
?>
