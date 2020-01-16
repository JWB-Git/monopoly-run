<?php
//Include config
require_once "../config/config.php";

//Define variables
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

//When form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

	//Validate User
	if(empty(trim($_POST["username"]))){
		$username_err = "Please enter a username";
	}
	else{
		//Prepare SQL statement
		$sql = "SELECT id FROM users WHERE username = ?";

		if($stmt = mysqli_prepare($link, $sql)){
			//Bind variables to prepared statement
			mysqli_stmt_bind_param($stmt, "s", $param_username);

			//Set parameters
			$param_username = trim($_POST["username"]);

			//Attempt to execute statement
			if(mysqli_stmt_execute($stmt)){
				//Store result
				mysqli_stmt_store_result($stmt);

				if(mysqli_stmt_num_rows($stmt) == 1){
					$username_err = "This username is already taken.";
				}
				else{
					$username = trim($_POST["username"]);
				}
			}
			else{
				echo "Oops, something went wrong! Please try again later";
			}
		}
		//Close statement
		mysqli_stmt_close($stmt);
	}

	//Validate Password
	if(empty(trim($_POST["password"]))){
		$password_err = "Please enter a password.";
	}
	elseif (strlen(trim($_POST["password"])) < 6){
			$password_err = "Your password must have at least 6 characters";
		}
	else{
		$password = trim($_POST['password']);
	}

	//Validate Confirm Password
	if(empty(trim($_POST['confirm-password']))){
		$confirm_password_err = "Please confirm password";
	}
	else{
		$confirm_password = trim($_POST["confirm-password"]);
		if(empty($password_err) && ($password != $confirm_password)){
			$confirm_password_err = "Password did not match.";
		}
	}

	//Check input errors before inserting
	if(empty($username_err) && empty($password_err) & empty($confirm_password_err)){
		//Prepare insert statement
		$sql = "INSERT INTO users (username, password) VALUES (?, ?)";

		if($stmt = mysqli_prepare($link, $sql)){
			//Bind variables to statement
			mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

			//Set parameters
			$param_username = $username;
			//Create password hash
			$param_password = password_hash($password, PASSWORD_DEFAULT);

			//Attempt to execute statement
			if(mysqli_stmt_execute($stmt)){
				//Redirect to login page
				header("location: login.php?action=registersuccess");
			}
			else{
				echo "Oops, something went wrong! Please try again later.";
			}
		}
		//Close statement
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
    <meta name="description" content="Register">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>Register</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Place your stylesheet here-->
    <link href="../css/main.css" rel="stylesheet" type="text/css">
	<link href="../css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="flex-container">
		<div class="row">
			<div class="col-sm register-image fill"></div>
			<div class="col-sm fill border rounded-lg shadow text-center login-container">
				<img class="mt-4 mb-2" src="../img/Full_Logo_Updated.svg" alt="NUSSAGG Logo" width=200px;>

				<h1 class="m-3 purple">Register</h1>

				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
						<label for="username">Username:</label>
						<input name="username" type="text" class="form-control w-75 mx-auto" placeholder="Username" value="<?php echo $username; ?>">
						<span class="help-block"><?php echo $username_err; ?></span>
					</div>
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : '' ?>">
						<label for="password">Password:</label>
						<input name="password" type="password" class="form-control w-75 mx-auto" placeholder="Password" value="<?php echo $password; ?>">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>
					<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
						<label for="password">Confirm Password:</label>
						<input name="confirm-password" type="password" class="form-control w-75 mx-auto" placeholder="Password" value="<?php echo $confirm_password; ?>">
						<span class="help-block"><?php echo $confirm_password_err; ?></span>
					</div>

					<input type="submit" class="btn background-purple px-5 mb-2" value="Register">
				</form>
				<br>
				<?php include "../footertext.php" ?>
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
