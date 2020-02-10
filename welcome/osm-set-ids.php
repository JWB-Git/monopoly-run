<?php
//Check if user is logged on and confirmed user
require_once "validuser.php";

//Required API's
require_once "../api/section-data.php";
require_once "../api/osm-functions.php";

$section = getSection($_SESSION['username']);

$term_disabled = "";
$event_disabled = "";

if($section['section_id'] == null){
	$term_disabled = "disabled";
}

if($section['term_id'] == null){
	$event_disabled = "disabled";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Monopoly Run - OSM User Settings">
    <meta name="author" content="Jack Burgess">
	<meta name="version" content="v1">
    <link rel="icon" href="../img/fleur_favicon.png">
    <title>OSM ID Settings</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Place your stylesheet here-->
    <link rel="stylesheet" href="../css/main.css" type="text/css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js" integrity="sha256-xzrHBImM2jn9oDLORlHS1/0ekn1VyypEkV1ALvUx8lU=" crossorigin="anonymous"></script>
</head>

<body>
	<?php include_once "navbar.php" ?>

	<main class="container-fluid mt-3">
		<div class="card">
			<div class="card-header">Select ID's</div>
			<div class="card-body">
				<ul class="nav nav-tabs nav-fill">
					<li class="nav-item">
						<a class="nav-link active" href="#section" role="tab" data-toggle="tab">1. Section</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $term_disabled; ?>" href="#term" role="tab" data-toggle="tab">2. Term</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php echo $event_disabled; ?>" href="#event" role="tab" data-toggle="tab">3. Event</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active p-3" id="section">
						<table id="section-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Section Name</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parts = array();
								$result = perform_query("ext/members/sectionplanning/?action=listSections", $parts)['items'];
								foreach($result as $section_arr){
								?>
								<tr>
									<td><?php echo $section_arr['sectionid']; ?></td>
									<td><?php echo $section_arr['name']; ?></td>
								</tr>
								<?php
								//End of foreach loop
								}
								?>
							</tbody>
						</table>

						<form action="submit-section-id.php" method="post" class="text-center mt-2">
                            <label for="group">Section ID:</label><br />
                            <div class="form-group mx-auto">
                                <input type="number" class="form-control d-inline w-50 ml-2" name="section-id" value="<?php echo $section['section_id']; ?>">
                            </div>
                            <input name="submit" type="submit" class="btn background-purple px-5 mb-2" value="Set Section ID">
                        </form>
					</div>
					<div role="tabpanel" class="tab-pane p-3" id="term">
						<table id="term-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Term Name</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parts = array();
								$result = perform_query("api.php?action=getTerms", $parts);
								$section_id = $section['section_id'];
								foreach($result[$section_id] as $term){
								?>
								<tr>
									<td><?php echo $term['termid']; ?></td>
									<td><?php echo $term['name']; ?></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>

						<form action="submit-term-id.php" method="post" class="text-center mt-2">
                            <label for="group">Term ID:</label><br />
                            <div class="form-group mx-auto">
                                <input type="number" class="form-control d-inline w-50 ml-2" name="term-id" value="<?php echo $section['term_id']; ?>">
                            </div>
                            <input name="submit" type="submit" class="btn background-purple px-5 mb-2" value="Set Term ID">
                        </form>
					</div>
					<div role="tabpanel" class="tab-pane p-3" id="event">
						<table id="event-table" class="table table-hover text-center">
							<thead>
								<tr>
									<th scope="col">ID</th>
									<th scope="col">Event Name</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$parts = array(
									"sectionid" => $section['section_id'],
									"termid" => $section['term_id']
								);
								$result = perform_query("ext/events/summary/?action=get", $parts);
								foreach($result['items'] as $event){
								?>
								<tr>
									<td><?php echo $event['eventid']; ?></td>
									<td><?php echo $event['name']; ?></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>

						<form action="submit-event-id.php" method="post" class="text-center mt-2">
                            <label for="group">Event ID:</label><br />
                            <div class="form-group mx-auto">
                                <input type="number" class="form-control d-inline w-50 ml-2" name="event-id" value="<?php echo $section['event_id']; ?>">
                            </div>
                            <input name="submit" type="submit" class="btn background-purple px-5 mb-2" value="Set Event ID">
                        </form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<footer class="bg-white p-3 mt-4 text-center">
		<?php include "../footertext.php" ?>
	</footer>

	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<!-- Sorted Table Scripts -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#section-table').DataTable();
			$('#term-table').DataTable();
			$('#event-table').DataTable();
		});
	</script>
</body>
</html>
