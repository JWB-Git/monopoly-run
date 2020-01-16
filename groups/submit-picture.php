<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Get Data Required For Page Information

//Location Data
if(isset($_GET['id'])){
	$id = $_GET['id'];

	$query = "SELECT name, colour, value, question, q_bonus FROM spaces WHERE id='".$id."'";
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			$location = $row['name'];
			$colour = $row['colour'];
			$value = $row['value'];
			$question = $row['question'];
			$q_bonus = $row['q_bonus'];
		}
	}
}
else{
	header("location: index.php?action=error");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - Submit Picture">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Submit Picture</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Place your stylesheet here-->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js" integrity="sha256-xzrHBImM2jn9oDLORlHS1/0ekn1VyypEkV1ALvUx8lU=" crossorigin="anonymous"></script>
</head>

<body>
	<?php include_once "navbar.php" ?>

	<div class="fluid-container m-4">
		<div class="row mb-3">
			<div class="col">
				<div class="card">
					<div class="card-header">Submit Picture</div>
					<div class="card-body">
						<p class="font-italic">Please only resubmit if the previous picture has been rejected or if you have deleted the previous submission, by clicking the delete button on the submission below.</p>
						<form action="upload-picture.php" method="post" enctype="multipart/form-data">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="group-name">Group Name: </span>
								</div>
								<input type="text" name="group" class="form-control" aria-label="Group Name" aria-described-by="group-name" value="<?php echo $_SESSION['username']; ?>" readonly>
							</div>
							<div class="input-group">
								<div class="input-group-prepend w-25">
									<span class="input-group-text w-100 <?php echo $colour; ?>" id="location">&nbsp;&nbsp;&nbsp;</span>
								</div>
								<input type="text" name="location" class="form-control font-weight-bold" aria-label="Location" aria-described-by="location" value="<?php echo $location; ?>" readonly>
							</div>
							<div class="input-group w-100 float-right mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="value">Q:</span>
								</div>
								<textarea type="text" name="value" class="form-control" aria-label="Value" aria-described-by="value" readonly><?php echo $question; ?></textarea>
							</div>
							<table class="table w-25 mb-3">
								<thead></thead>
								<tbody>
									<tr>
										<th scope="row" class="w-50">Value (£):</th>
										<td><?php echo $value; ?></td>
									</tr>
									<tr>
										<th scope="row">Question Bonus (£):</th>
										<td><?php echo $q_bonus; ?></td>
									</tr>
								</tbody>
							</table>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="answer">Question Answer: </span>
								</div>
								<input type="text" name="answer" class="form-control" aria-label="Answer" aria-described-by="answer">
							</div>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="value">Select File: </span>
								</div>
								<input type="file" name="file" id="file" class="custom-input-height" accept="image/*" required>
							</div>
							<div class="input-group mb-3">
								<input name="submit" type="submit" class="btn background-purple btn-block" value="Submit">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col">
				<div class="card">
					<div class="card-header">Previous Submissions</div>
					<div class="card-body">
						<div class="container-fluid">
							<?php
							$query = "SELECT id, created_at, img_name, checked, comment, answer from uploads WHERE group_name = '".$_SESSION['username']."' AND location = '".$location."'";
								$result = mysqli_query($link, $query);
								if(mysqli_num_rows($result) >= 1){
									while($row = mysqli_fetch_array($result)){
										$id = $row['id'];
										$datetime = $row['created_at'];
										$img_name = $row['img_name'];
										$checked = $row['checked'];
										$comment = $row['comment'];
										$answer = $row['answer'];

										//Set Checked Icon
										$checked_icon="";
										$checked_text="";
										if($checked == 0){
											$checked_icon = "text-warning fas fa-minus-circle";
											$checked_text = "Still to be checked";
										}
										else if($checked == 1){
											$checked_icon = "text-success fas fa-check-circle";
											$checked_text = "Submission Checked";
										}
										else if($checked == 2){
											$checked_icon = "text-danger fas fa-times-circle";
											$checked_text = "Submission Denied";
										}
										else{
											$checked_icon = "text-danger fas fa-exclamation-circle";
											$checked_text = "ERROR!!!";
										}
							?>
							<div class="row mb-2">
								<div class="col">
									<p class="font-italic float-left p-2"><?php echo $datetime; ?></p>
									<p class="float-right border rounded p-2"><i class="<?php echo $checked_icon; ?> mr-2"></i><?php echo $checked_text; ?></p>
									<img class="mb-2" src="../uploads/<?php echo $img_name ?>" alt="Uploaded Image" width="100%">
									<p class="p-2 border rounded text-center"><span class="font-weight-bold">Question Answer:</span><br><?php echo $answer; ?></p>
									<p class="p-2 border rounded text-center"><span class="font-weight-bold">Gamemaster Comment:</span><br><?php echo $comment; ?></p>
									<a class="btn btn-danger mb-2" href="delete-submission.php?id=<?php echo $id; ?>">Delete Submission</a>
									<hr>
								</div>
							</div>
							<?php
									}
								}
								else{
							?>
								<div class="row">
									<div class="col">
										<p class="font-italic">No Previous Submissions</p>
									</div>
								</div>
							<?php
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer class="bg-white p-3 mt-4 text-center">
		<?php include "../footertext.php" ?>
	</footer>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
