<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API Files
require_once "../api/user-data.php";

//Check if admin user
if(!isAdmin($_SESSION['username'])){
	header("location: index.php?access-denied");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - Settings">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Settings</title>

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
					<div class="card-header">Users</div>
					<div class="card-body">
						<table id="submission-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">Username</th>
									<th scope="col">Confirmed</th>
									<th scope="col">Admin</th>
									<th scope="col">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach(getAllUsers() as $user){
								?>
								<tr>
									<td class="align-middle"><?php echo $user['username']; ?></td>
									<td>
										<?php
											if($user['confirmed_user'] == 1){
												echo '<i class="fas fa-check-circle"></i>';
											}
										?>
									</td>
									<td>
										<?php
											if($user['admin'] == 1){
												echo '<i class="fas fa-check-circle"></i>';
											}
										?>
									</td>

									<td>
										<?php
										if($user['username'] != $_SESSION['username']){
										?>
										<a href="delete-user.php?id=<?php echo $user['id']; ?>" title="Make Admin">
											<i class="mx-2 text-danger fas fa-trash"></i>
										</a>
										<?php
										}
										else{
											echo 'No Actions Available';
										}
										?>

										<?php
										if($user['admin'] == 0 && $user['confirmed_user'] == 1){
										?>
										<a href="make-admin.php?id=<?php echo $user['id']; ?>" title="Make Admin">
											<i class="mx-2 text-warning fas fa-crown"></i>
										</a>
										<?php
										}
										?>

										<?php
										if($user['confirmed_user'] == 0){
										?>
										<a href="confirm-user.php?id=<?php echo $user['id']; ?>" title="Confirm User">
											<i class="mx-2 text-success fas fa-check"></i>
										</a>
										<?php
										}
										?>
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
