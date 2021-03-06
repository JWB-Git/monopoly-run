<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - Admin Home">
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
		<div class="row mb-3">
			<div class="col">
				<div class="card">
					<div class="card-header">
						Submissions to be checked
					</div>
					<div class="card-body">
						<p class="font-italic">Click on the row you wish to check.</p>

						<table id="submission-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">Date-Time Stamp</th>
									<th scope="col">Team Name</th>
									<th scope="col">Location</th>
									<th scope="col">Photo</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = "SELECT id, created_at, group_name, location, img_name FROM uploads WHERE checked='0'";
								$result = mysqli_query($link, $query);
								if(mysqli_num_rows($result) >= 1){
									while($row = mysqli_fetch_array($result)){
										$id = $row['id'];
										$datetime = $row['created_at'];
										$group_name = $row['group_name'];
										$location = $row['location'];
										$img_name = $row['img_name'];
								?>
								<tr class="clickable-row" data-href="check-submission.php?id=<?php echo $id; ?>">
									<td class="align-middle"><?php echo $datetime; ?></td>
									<td class="align-middle"><?php echo $group_name; ?></td>
									<td class="align-middle"><?php echo $location;?></td>
									<td>
										<img src="../uploads/<?php echo $img_name; ?>" alt="<?php echo $img_name; ?>" height="40px">
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

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header">
						Teams
					</div>
					<div class="card-body">
						<p class="font-italic">Click on the team you wish to check. Sort the table by clicking the headers</p>

						<table id="group-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">Team Name</th>
									<th scope="col">Points</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$query = "SELECT id, group_name, points_deduct FROM groups";
								$result = mysqli_query($link, $query);
								if(mysqli_num_rows($result) >= 1){
									while($row = mysqli_fetch_array($result)){
										$id = $row['id'];
										$group_name = $row['group_name'];
										$points_deduct = $row['points_deduct'];
										$points = -$points_deduct;

										$query2 = "SELECT location, question_correct FROM uploads WHERE group_name='".$group_name."' AND checked=1";
										$result2 = mysqli_query($link, $query2);
										if(mysqli_num_rows($result2) >= 1){
											while($row2 = mysqli_fetch_array($result2)){
												$location = $row2['location'];
												$question_correct = $row2['question_correct'];

												$query3 = "SELECT value, q_bonus FROM spaces WHERE name='".$location."'";
												$result3 = mysqli_query($link, $query3);
												if(mysqli_num_rows($result3) == 1){
													while($row3 = mysqli_fetch_array($result3)){
														$value = $row3['value'];
														$q_bonus = $row3['q_bonus'];
														$points += $value;
														if($question_correct == 1){
															$points += $q_bonus;
														}
													}

												}
											}
										}
								?>
								<tr class="clickable-row" data-href="view-group.php?id=<?php echo $id; ?>">
									<td class="align-middle"><?php echo $group_name; ?></td>
									<td class="align-middle"><?php echo $points; ?></td>
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

	<!-- Clickable Row Script -->
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".clickable-row").click(function(){
				window.location = $(this).data("href");
			});
		});
	</script>

	<!-- Sorted Table Scripts -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#group-table').DataTable();
			$('#submission-table').DataTable();
		});
	</script>
</body>
</html>
