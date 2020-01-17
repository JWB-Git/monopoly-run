<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API Files
require_once "../api/location-data.php";
require_once "../api/upload-data.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - Group Home">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Home</title>

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
					<div class="card-header">
						Spaces
					</div>
					<div class="card-body">
						<p class="font-italic d-md-none">Slide left and right to view the full table</p>
						<div class="table-responsive">
						<table class="table text-center">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">Location</th>
									<th scope="col">Value</th>
									<th scope="col">Question Bonus</th>
									<th scope="col">Submit Photo</th>
									<th scope="col">Status</th>
									<th scope="col">Question</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach(getAllLocations() as $location){
								?>
								<tr>
									<td class="<?php echo $location['colour']; ?>"></td>
									<td class="align-middle"><?php echo $location['name']; ?></td>
									<td class="align-middle">£<?php echo $location['value'];?></td>
									<td class="align-middle">£<?php echo $location['q_bonus'];?></td>
									<td class="align-middle">
										<a href="submit-picture.php?id=<?php echo $location['id']; ?>" class="btn background-purple px-3">Submit&#47;View</a>
									</td>
									<td class="align-middle">
										<!-- Status PHP Goes Here --->
										<?php
										$checked_icon="";
										$question_icon="";

										$statuses = getUploadStatuses($_SESSION['username'], $location['name']);
										?>
										<i class="<?php echo $statuses['checked_icon']; ?>"></i>
									</td>
									<td class="align-middle">
										<i class="<?php echo $statuses['question_icon']; ?>"></i>
									</td>
								</tr>

								<?php
								//End of foreach loop
								}
								?>
							</tbody>
						</table>
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
