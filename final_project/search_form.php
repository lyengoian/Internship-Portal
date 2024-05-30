<?php
		require 'config/config.php';


	$mysqli = new mysqli(host, user, pass, db);

	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}
	$sql_locations = "SELECT * FROM location_table;";
	$sql_roles = "SELECT * FROM role_table;";
	$sql_open_or_closed = "SELECT * FROM open_table;";

	$results_locations = $mysqli->query( $sql_locations );
	$results_roles = $mysqli->query( $sql_roles );
	$results_open_or_closed = $mysqli->query( $sql_open_or_closed );

	if ( !$results_locations ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	if ( !$results_roles ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

	if ( !$results_open_or_closed ) {
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

	<title>Internship Search Form</title>
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item active">Search</li>
		<li class="breadcrumb-item"><a href="add_internship.php">Add</a></li>
		<li class="breadcrumb-item"><a href="delete_internship.php">Delete</a></li>		
		<li class="breadcrumb-item"><a href="edit_internship.php">Edit</a></li>
	</ol>
	<div class="container">
		<div class="row">
			<h1>Internship Search Form</h1>
		</div> 
	</div> 
	<div class="container">

		<form action="search_results.php" method="GET">

		<div class="formdiv">
				<label for="company">Company Name:</label>
				<div class="formdivdiv">					
					<input type="text" class="form-control" id="company" name="company">
				</div>
			</div> 

			<div class="formdiv">
				<label for="location_name">Location:</label>
				<div class="formdivdiv">					
					<select name="location_name" id="location_name" class="form-control">
						<option value="" selected>-- Select One --</option>

						<?php while ( $row = $results_locations->fetch_assoc() ) : ?>
							<option value="<?php echo $row['location_id']; ?>">
								<?php echo $row['location_name']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> 
			<div class="formdiv">
				<label for="role_title">Role:</label>
				<div class="formdivdiv">					
					<select name="role_title" id="role_title">
						<option value="" selected>-- Select One --</option>
						<?php while ( $row = $results_roles->fetch_assoc() ) : ?>
							<option value="<?php echo $row['role_title_id']; ?>">
								<?php echo $row['role_title']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> 

			<div class="formdiv">
				<label>Status:</label>
					<div>
						<input class="radios" type="radio" id="customRadioInline1" name="open_yesno" value=1>
					  	<label class="radios" for="customRadioInline1">Open</label>
					</div>
					<div>
					  <input class="radios" type="radio" id="customRadioInline2" name="open_yesno" value=2>
					  <label class="radios" for="customRadioInline2">Closed</label>
					</div>
			</div> 
			<div>
				<div></div>
				<div>
					<button type="submit" class="submit">Search</button>
					<button type="reset" class="reset">Reset</button>
				</div>
			</div>
		</form>
	</div> 
</body>
</html>
