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
				<a class="nav-link" href="team-allocation.php"><i class="fas fa-users"></i>&nbsp;Team Allocation</a>
	  		</li>

			<li class="nav-item">
				<a class="nav-link" href="videos.php"><i class="fas fa-video"></i>&nbsp;Videos</a>
	  		</li>

            <li class="nav-item dropdown">
              	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                	<i class="fas fa-campground"></i>&nbsp;OSM Configuration
              	</a>
              	<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="osm-user-settings.php">User Settings</a>
					<a class="dropdown-item" href="osm-set-ids.php">Set ID's</a>
              	</div>
            </li>

			<li class="nav-item">
				<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log Out</a>
	  		</li>
		</ul>
  	</div>
</nav>
