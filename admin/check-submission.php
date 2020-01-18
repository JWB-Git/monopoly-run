<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API Files
require_once "../api/upload-data.php";
require_once "../api/location-data.php";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$upload = getUpload($id);

	$ans = getLocationValues($upload['location']);
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
    <meta name="description" content="Monopoly Run - Check Submission">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Check Submission</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Place your stylesheet here-->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js" integrity="sha256-xzrHBImM2jn9oDLORlHS1/0ekn1VyypEkV1ALvUx8lU=" crossorigin="anonymous"></script>
</head>

<body>
	<?php include_once "navbar.php" ?>

	<div class="fluid-container m-4">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">Submission</div>
					<div class="card-body">
						<p><span class="font-weight-bold">Location: </span><?php echo $upload['location']; ?></p>
						<p><span class="font-weight-bold">Group Name: </span><?php echo $upload['group_name']; ?></p>
						<p class="font-weight-bold">Picture:</p>
						<img src="../uploads/<?php echo $upload['img_name']; ?>" width="100%" class="mb-3">
						<p><span class="font-weight-bold">Answer: </span><?php echo $upload['answer']; ?></p>
						<p><span class="font-weight-bold">Correct Answer: </span><?php echo $ans['correct_ans']; ?></p>
						<hr>

						<form action="update-submission.php" method="post">
							<div class="input-group mb-3">
								<input type="text" name="id" class="form-control d-none" aria-label="ID" aria-described-by="id" value="<?php echo $id; ?>" readonly>
							</div>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="comment">Comment: </span>
								</div>
								<input type="text" name="comment" class="form-control" aria-label="Comment" aria-described-by="comment">
							</div>
							<div class="input-group mb-3">
								<input class="d-inline w-33 btn btn-success" type="submit" name="mark-as-correct" value="Mark as Correct (Question Correct)">
								<input class="d-inline w-33 btn btn-warning" type="submit" name="mark-as-semi-correct" value="Mark as Correct (Question Wrong)">
								<input class="d-inline w-33 btn btn-danger" type="submit" name="mark-as-wrong" value="Mark as Wrong">
							</div>
						</form>
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
