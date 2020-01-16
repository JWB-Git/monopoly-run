<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

if(isset($_GET['id'])){
	$id = $_GET['id'];

	$query="SELECT group_name, points_deduct FROM groups where id=".$id;
	$result = mysqli_query($link, $query);
	if(mysqli_num_rows($result) == 1){
		while($row = mysqli_fetch_array($result)){
			$group_name = $row['group_name'];
			$points_deduct = $row['points_deduct'];
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
    <meta name="description" content="Monopoly Run - View Group">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title><?php echo $group_name; ?></title>

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
						<?php echo $group_name; ?>
					</div>
					<div class="card-body">
						<table class="table text-center">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col">Location</th>
									<th scope="col">Status</th>
									<th scope="col">Question</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = "SELECT name, colour FROM spaces";
								$result = mysqli_query($link, $query);
								if(mysqli_num_rows($result) >= 1){
									while($row = mysqli_fetch_array($result)){
										$location = $row['name'];
										$colour = $row['colour'];
								?>
								<tr>
									<td class="<?php echo $colour; ?>"></td>
									<td class="align-middle"><?php echo $location; ?></td>
									<td class="align-middle">
										<!-- Status PHP Goes Here --->
										<?php
										$checked_icon="";
										$question_icon="";

										$query2 = "SELECT checked, question_correct FROM uploads WHERE group_name = '".$group_name."' AND location = '".$location."'";
										$result2 = mysqli_query($link, $query2);
										if(mysqli_num_rows($result2) >= 1){
											while($row2 = mysqli_fetch_array($result2)){
												$checked = $row2['checked'];
												$question_correct = $row2['question_correct'];

												if($checked == 0){
													$checked_icon = "text-warning fas fa-minus-circle";
													}
												else if($checked == 1){
													$checked_icon = "text-success fas fa-check-circle";
													}
												else if($checked == 2){
													$checked_icon = "text-danger fas fa-times-circle";
													}
												else{
													$checked_icon = "text-danger fas fa-exclamation-circle";
													}
												}

												if($question_correct == 0 && $checked == 0){
													$question_icon = "text-warning fas fa-minus-circle";
												}
												else if($question_correct == 0){
													$question_icon = "text-danger fas fa-times-circle";
												}
												else if($question_correct == 1){
													$question_icon = "text-success fas fa-check-circle";
												}
												else{
													$question_icon = "text-danger fas fa-exclamation-circle";
												}
											}
										else{
											$checked_icon="fas fa-arrow-circle-up";
											$question_icon="fas fa-arrow-circle-up";
										}
										?>
										<i class="<?php echo $checked_icon; ?>"></i>
									</td>
									<td>
										<i class="<?php echo $question_icon; ?>"></i>
									</td>
								</tr>

								<?php
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col">
				<div class="card">
					<div class="card-header">Deduct Points</div>
					<div class="card-body">
						<i>Enter positive numbers only!</i>
						<form action="deduct-points.php?id=<?php echo $id; ?>" method="post" class="mt-2">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text" id="amount">Deduction Amount:</span>
								</div>
								<input type="number" name="points_deduct" class="form-control" aria-label="Amount" aria-described-by="amount" value="<?php echo $points_deduct; ?>">
							</div>
							<div class="input-group mb-3">
								<input name="submit" type="submit" class="btn background-purple btn-block" value="Update">
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
