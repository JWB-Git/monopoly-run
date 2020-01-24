<?php
//Require API Files
require_once "../api/user-data.php";
?>

<style>
	.navbar-custom {
		background-color: #fff;
	}
	/* change the brand and text color */
	.navbar-custom .navbar-brand,
	.navbar-custom .navbar-text {
		color: #7413dc;
	}
	/* change the link color */
	.navbar-custom .navbar-nav .nav-link {
		color: #7413dc;
	}
	/* change the color of active or hovered links */
	.navbar-custom .nav-item.active .nav-link,
	.navbar-custom .nav-item:hover .nav-link {
		color: #00a794;
	}

	.navbar-custom .dropdown-item{
		color: #7413dc;
	}
</style>

<nav class="navbar navbar-expand-sm navbar-custom bg-white">
  	<a class="navbar-brand" href="index.php">
		<img class="mr-2" src="../img/Scouts_Logo_Stack_Purple.png" alt="logo" height="30px">
	</a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
	<i class="fas fa-bars purple"></i>
	</button>

  	<div class="collapse navbar-collapse" id="navbar">
		<ul class="navbar-nav mr-auto">
	  		<li class="nav-item">
				<a class="nav-link" href="index.php"><i class="fas fa-home"></i>&nbsp;Home</a>
	  		</li>
			<li class="nav-item">
				<a class="nav-link" href="all-submissions.php"><i class="fas fa-list"></i>&nbsp;All Submissions</a>
	  		</li>
			<li class="nav-item">
				<a class="nav-link" href="register-group.php"><i class="fas fa-user-plus"></i>&nbsp;Register Team</a>
	  		</li>

			<?php
			if(isAdmin($_SESSION['username'])){
			?>
			<li class="nav-item">
				<a class="nav-link" href="settings.php"><i class="fas fa-cog"></i>&nbsp;Settings</a>
	  		</li>
			<?php
			}
			?>

	  		<li class="nav-item">
				<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log Out</a>
	  		</li>
		</ul>
  	</div>
</nav>
