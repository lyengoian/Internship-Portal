<?php
	require 'config/config.php';


	$mysqli = new mysqli(host, user, pass, db);

	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');
	$sql = "SELECT internship_table.int_id AS int_id, open_table.open_yesno AS open_yesno, internship_table.company AS company, location_table.location_name AS location_name, role_table.role_title AS role_title
			FROM internship_table
			LEFT JOIN location_table
				ON internship_table.location = location_table.location_id
			LEFT JOIN open_table
				ON internship_table.open = open_table.open_id
			LEFT JOIN role_table
				ON internship_table.role = role_table.role_title_id
			WHERE 1 = 1";

	if (isset($_GET['company']) && !empty($_GET['company'])) {
		$company = $_GET['company'];
		$rescompany = str_replace("'", "''", $company);
		$sql = $sql . " AND internship_table.company LIKE '%$rescompany%'";
	}


	if (isset($_GET['location_name']) && !empty($_GET['location_name'])) {
		$location_name = $_GET['location_name'];
		$sql = $sql . " AND internship_table.location = $location_name";
	}


	if (isset($_GET['open_yesno']) && !empty($_GET['open_yesno'])) {
		$open_yesno = $_GET['open_yesno'];
		$sql = $sql . " AND internship_table.open = $open_yesno";
	}
	
	if (isset($_GET['role_title']) && !empty($_GET['role_title'])) {
		$role_title = $_GET['role_title'];
		$sql = $sql . " AND internship_table.role = $role_title";
	}


	$sql = $sql . ";";


	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$total_results = $results->num_rows;
	$results_per_page = 15;
	$last_page = ceil($total_results / $results_per_page);

	if ( isset($_GET['page']) && trim($_GET['page']) != '') {
		$current_page = $_GET['page'];
	} else {
		$current_page = 1;
	}

	if ( $current_page < 1 || $current_page > $last_page) {
		$current_page = 1;
	}
	
	$start_index = ($current_page - 1) * $results_per_page;

	$sql = rtrim($sql, ';');

	$sql = $sql . " LIMIT $start_index, $results_per_page;";

	$results = $mysqli->query($sql);

	if ( !$results ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="styling.css">

	<title>Internships</title>
</head>
<body>
	<div class="container">
		<div class="row">
			<h1>Internships</h1>
		</div> 
	</div> 
	<div class="container">
		<div>
			<div class="back-left">
				<a href="search_form.php" role="button"><< Back</a>
			</div>
		</div>
		<div class="row">

		<div>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">First</a>
					</li>
					<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $current_page - 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>"><<</a>
					</li>
					<li class="page-item active">
						<a class="page-link" href="">
							<?php echo $current_page; ?>
						</a>
					</li>
					<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $current_page + 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">>></a>
					</li>
					<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $last_page;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">Last</a>
					</li>
				</ul>
			</nav>
		</div> 
	</div> 
		<div><h3>Showing <?php echo $results->num_rows; ?> / <?php echo $total_results ; ?> total result(s).</h3></div>
			<div id="alljobs">
				<?php while ( $row = $results->fetch_assoc() ) : ?>		
					<div class = "jobcard">
						<div class="company">
						<?php echo $row['company'];?>
						</div>
						<div class="location">
						<?php echo $row['location_name']; ?>
						</div>
						<div class = "role">
						<?php echo $row['role_title']; ?>
						
						</div>
						<div class="open">
						<?php echo $row['open_yesno']; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div> 
		</div>
		<div>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">First</a>
					</li>
					<li class="page-item <?php if ( $current_page <= 1 ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $current_page - 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>"><<</a>
					</li>
					<li class="page-item active">
						<a class="page-link" href="">
							<?php echo $current_page; ?>
						</a>
					</li>
					<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $current_page + 1;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">>></a>
					</li>
					<li class="page-item <?php if ( $current_page >= $last_page ) { echo 'disabled';} ?>">
						<a class="page-link" href="<?php 
							$_GET['page'] = $last_page;
							echo $_SERVER['PHP_SELF'] . "?" . http_build_query($_GET);
						?>">Last</a>
					</li>
				</ul>
			</nav>
		</div> 
</body>
</html>
