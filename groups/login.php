<?php
//Initialise session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === "group"){
	header("location: index.php");
	exit;
}

//Include config file
require_once "../config/config.php";

//Define variables
$username = $password = "";
$username_err = $password_err = "";

//When form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	//Check if username is empty
	if(empty(trim($_POST["username"]))){
		$username_err = "Please enter username.";
	}
	else{
		$username = trim($_POST['username']);
	}

	//Check if password is empty
	if(empty(trim($_POST["password"]))){
		$username_err = "Please enter password.";
	}
	else{
		$password = trim($_POST["password"]);
	}

	//Validate credentials
	if(empty($username_err) && empty($password_err)){
		//Prepare select statement
		$sql = "SELECT id, group_name, password FROM groups WHERE group_name = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			//Bind variables
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			//Set parameters
			$param_username = $username;

			//Attempt to execute statement
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
			}

			//Check if username exist
			if(mysqli_stmt_num_rows($stmt) == 1){
				//Bind result vairables

				mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

				if(mysqli_stmt_fetch($stmt)){
					if(password_verify($password, $hashed_password)){
						//Password is correct, start new session
						session_start();

						//Store data in session variables
						$_SESSION["loggedin"] = "group";
						$_SESSION["id"] = $id;
						$_SESSION["username"] = $username;

						//Redirect to index
						header("location: index.php");
					}
					else{
						$password_err = "The password you entered was not valid.";
					}
				}
				else{
					echo "Oops, something went wrong! Please try again later.";
				}
			}
		}
		//Close Statement
		mysqli_stmt_close($stmt);
	}
	//Close connection
	mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Login">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Place your stylesheet here-->
    <link href="../css/main.css" rel="stylesheet" type="text/css">
	<link href="../css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="flex-container">
		<div class="row no-gutters">
			<div class="col-sm fill login-image"></div>
			<div class="col-sm fill border rounded-lg shadow text-center login-container">
				<?php
				//Check if user is alreaded logged in
				if(isset($_GET['action'])){
					$action = htmlspecialchars($_GET['action']);
					if($action === "logout"){
						echo '
						<div class="alert alert-success" role="alert">
							Logout Succesful
						</div>
						';
					}
					else if($action === "registersuccess"){
						echo
						'<div class="alert alert-success" role="alert">
							User successfully created.
						</div>';
					}
					else{
						echo
						'<div class="alert alert-danger" role="alert">
							Somethings gone wrong here...
						</div>';
					}
				}
				?>
				<img class="mt-4 mb-2" src="../img/Scouts_Logo_Stack_Purple.png" alt="Fleur De Lis" width=200px;>

				<h1 class="m-3 purple">Group Login</h1>

				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : '' ?>">
						<label for="username">Group Name:</label>
						<input name="username" type="text" class="form-control w-75 mx-auto" placeholder="Group Name" value="<?php echo $username; ?>">
						<span class="help-block"><?php echo $username_err; ?></span>
					</div>
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : '' ?>">
						<label for="password">Password:</label>
						<input name="password" type="password" class="form-control w-75 mx-auto" placeholder="Password">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>

					<input type="submit" class="btn background-purple px-5 mb-2" value=Login>
				</form>
				<br>
				<?php include "../footertext.php" ?>
				<p>
					<a href="../admin/login.php">Go to admin login</a>
				</p>
			</div>
		</div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
