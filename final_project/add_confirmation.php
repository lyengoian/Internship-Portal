<?php
	if ( !isset($_POST['location_name']) || trim($_POST['location_name']) == ''
		|| !isset($_POST['company_name']) || trim($_POST['company_name']) == ''
		|| !isset($_POST['role_title']) || trim($_POST['role_title']) == ''
		|| !isset($_POST['open_yesno']) || trim($_POST['open_yesno']) == ''
		|| ($_POST['location_name'] == "Other" && (!isset($_POST['location_name_other']) || trim($_POST['location_name_other']) == '' ))
		|| ($_POST['role_title'] == "Other" && (!isset($_POST['role_title_other']) || trim($_POST['role_title_other']) == '') )  
		) {
		$error = "Please fill out all required fields.";
	} else {
		require 'config/config.php';

		$mysqli = new mysqli(host, user, pass, db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$company_name = $_POST['company_name'];
		$open_yesno = $_POST['open_yesno'];


		$bool_loc_other = FALSE;
	    $bool_role_other = FALSE;

		$location_name = $_POST['location_name'];
		$location_id = $_POST['location_name'];
		//if the user chose other
		if($location_name == "Other"){
			$location_name = $_POST['location_name_other'];
			echo "the user entered new location";
			$bool_loc_other = TRUE;
			$sql_location_id = "SELECT * FROM location_table;";
			if ($result = mysqli_query($mysqli, $sql_location_id)) {
				$rowcount = mysqli_num_rows( $result );
				$location_id = $rowcount;
			}
			if($bool_loc_other == TRUE){
				$location_id = $rowcount + 1;
				$sql = "INSERT INTO location_table (location_id, location_name)
				VALUES ($location_id, '$location_name');";
				$results = $mysqli->query($sql);
			}
		}else if ($location_name != "Other" && $location_name != NULL){
			$location_name = $_POST['location_name'];
			echo "the user entered " . $location_name;
		}

		//if the user chose other
		$role_title = $_POST['role_title'];
		$role_title_id = $_POST['role_title'];
		if($role_title == "Other"){
			$role_title = $_POST['role_title_other'];
			echo "the user entered new role";
			$bool_role_other = TRUE;
			$sql_role_title_id = "SELECT * FROM role_table;";
			if ($result = mysqli_query($mysqli, $sql_role_title_id)) {
				$rowcount = mysqli_num_rows( $result );
				$role_title_id = $rowcount;
			}
			if($bool_role_other == TRUE){
				$role_title_id = $rowcount + 1;
				$sql = "INSERT INTO role_table (role_title_id, role_title)
				VALUES ($role_title_id, '$role_title');";
				$results = $mysqli->query($sql);
			}
			
		}else if ($role_title != "Other" && $role_title != NULL){
			$role_title = $_POST['role_title'];
			echo "the user entered " . $role_title;
		}

		$sql_int_id = "SELECT * FROM internship_table;";
		if ($result = mysqli_query($mysqli, $sql_int_id)) {
			$rowcount = mysqli_num_rows( $result );
		}
		$int_id = $rowcount + 1;

		$sql = "INSERT INTO internship_table (int_id, company, location, role, open)
				VALUES ($int_id, '$company_name', $location_id, $role_title_id, $open_yesno);";

		$results = $mysqli->query($sql);


		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="styling.css">

	<title>Add Internship</title>
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="add_internship.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1>Add an Internship</h1>
		</div>
	</div> 
	<div class="container">
		<div>
			<div>

				<?php if ( isset($error) && trim($error) != '' ) : ?>

					<div class="text-danger">
						<?php echo $error; ?>
					</div>

				<?php else : ?>

					<div class="text-success">
						<span class="font-italic"><?php echo $company_name; ?></span> was successfully added.
					</div>

				<?php endif; ?>

			</div> 
		</div> 
		<div>
			<div class="back">
				<a href="add_internship.php" role="button" class="btn btn-primary"><< Back</a>
			</div> 
		</div> 
	</div> 
</body>
</html>