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
		<img class="mr-2" src="../img/Full_Logo_Updated.svg" alt="logo" height="30px">
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
				<a class="nav-link" href="../img/tw-metro-map.jpg" target="_blank"><i class="far fa-map"></i>&nbsp;Metro Map</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="https://www.google.com/maps/d/u/2/viewer?mid=1JsHVAxGlWk0o3a8oIxvCRB_QSXfW_DOK&ll=55.00095151645751%2C-1.5209032999999863&z=12" target="_blank"><i class="far fa-map"></i>&nbsp;Location Map</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bus"></i> Bus Replacement Information</a>
				<div class="dropdown-menu" aria-labelledby="dropdown">
					<a class="dropdown-item" href="https://www.nexus.org.uk/sites/default/files/bus_saturday_23_november_2019v1_-_connection_v4.pdf" target="_blank"><i class="fas fa-table"></i> Timetable</a>
					<a class="dropdown-item" href="https://www.nexus.org.uk/sites/default/files/23_24_nov_rgt-_hth_bus_0.pdf" target="_blank"><i class="fas fa-thumbs-up"></i> Bus Stop Locations</a>
				</div>
	  		</li>
			<li class="nav-item">
				<a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Log Out</a>
	  		</li>
		</ul>
  	</div>
</nav>
