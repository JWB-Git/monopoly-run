<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API's
require_once "../api/osm-functions.php";
require_once "../api/section-data.php";
require_once "../api/encryption.php";

$alert = "";
$section = getSection($_SESSION['username']);
if(osmSecretSet() == 0){


	if($section['osm_email'] == null || $section['osm_password'] == null){
		$alert =
			"<div class='alert alert-danger w-100' role='alert'>
  					Your OSM Details haven't been set. Please visit the User Settings page to set your details.
			</div>";
	}
	else{
		$auth = authorise();

		if(array_key_exists('secret', $auth) && array_key_exists('userid', $auth)){
			$_SESSION['osm_secret'] = $auth['secret'];
			$_SESSION['osm_user_id'] = $auth['userid'];
		}

		else{
			$alert =
				"<div class='alert alert-danger w-100' role='alert'>
  					".$auth->error.". Please check your OSM User Settings
				</div>";
		}
	}
}
if($section['section_id'] == null || $section['term_id'] == null || $section['event_id'] == null){
	$alert =
		"<div class='alert alert-danger w-100' role='alert'>
  				One or more ID's haven't been set. Please visit the 'Set ID's' page to set them.
		</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - Welcome Home">
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

	<main class="container-fluid">
		<div class="row">
			<?php echo $alert; ?>
		</div>

		<?php
		if($section['section_id'] != null && $section['term_id'] != null && $section['event_id'] != null && $section['teams_sorted'] == 0){
		?>
		<div class="row mt-3">
			<div class="col">
				<div class="card">
					<div class="card-header">Team Organiser</div>
					<div class="card-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-sm">
									<input type="text" class="form-control d-inline w-100" value="No Team" readonly="readonly" />
									<ul id="no-team" class="team border p-1 list-group">
									<?php
									$parts = array(
										"eventid" => $section['event_id'],
										"termid" => $section['term_id'],
										"sectionid" => $section['section_id']
									);
									$result = perform_query("ext/events/event/?action=getAttendance", $parts)['items'];
									foreach($result as $scout){
										if($scout['attending'] == "Yes"){
											echo '<li class="list-group-item">'.$scout['scoutid'].": ".$scout['firstname'].' '.$scout['lastname'].'</li>';
										}
									}
									?>
									</ul>
								</div>

								<?php
								$sortable_string = "#no-team";

								for($i=0; $i<$section['no_teams']; $i++){
									$sortable_team = "team".$i;
									$sortable_string = $sortable_string.", #".$sortable_team;
								?>
								<div class="col-sm teams-div">
									<input type="text" class="form-control d-inline w-100" placeholder="Team Name"/>
									<ul id="<?php echo $sortable_team; ?>" class="team border p-1 list-group"></ul>
								</div>
								<?php
								}
								?>
							</div>
							<div class="row mt-3">
								<div class="col">
									<form method="post" id="submit-teams" action="submit-teams.php" class="text-center">
										<input name="json-string" type="hidden" value="" id="json-string" />
										<input type="submit" value="Submit Teams" class="btn background-purple px-5 mb-2" />
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<?php
		}
		else if($section['section_id'] != null && $section['term_id'] != null && $section['event_id'] != null && $section['teams_sorted'] == 1){
		?>
		<div class="row mt-3">
			<div class="col">
				<div class="card">
					<div class="card-header">Your Teams</div>
					<div class="card-body">

					</div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
	</main>

	<footer class="bg-white p-3 mt-4 text-center">
		<?php include "../footertext.php" ?>
	</footer>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- Moveable List Script -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$("<?php echo $sortable_string; ?>").sortable({
			connectWith: ".team"
		}).disableSelection();
	});
	</script>

	<!-- Submit Teams pre-processing and submittion -->
	<script type="text/javascript">
	$('#submit-teams').submit(function() {
		var id=0;

    	var output = {};

		var teamNameCheck = true;

		$('.teams-div').each(function(){
			//Get and add Team Name to array-object
			var teamName = $($(this).children()[0]).val();
			if(teamName == ""){
				teamNameCheck = false;
			}
			output[id] = {};
			output[id]['team-name'] = teamName;
			output[id]['members'] = {};

			//Get and add Team Members to array-object
			var members = $($(this).children()[1]).children();

			var i=0;
			$(members).each(function(){
				var memberText = $(this).text();
				mid = memberText.substr(0, memberText.indexOf(':'));
				name = memberText.substr(memberText.indexOf(':') + 2, memberText.length);

				output[id]['members'][i] = {};
				output[id]['members'][i]["id"] = parseInt(mid);
				output[id]['members'][i]["name"] = name;

				i++;
			});
			id++;
		});

		if(!teamNameCheck){
			alert("One or more team names have not been filled in");
			return false;
		}

		$('#json-string').val(JSON.stringify(output));

    	return true;
	});
	</script>
</body>
</html>
