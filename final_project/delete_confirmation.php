<?php
		require 'config/config.php';

	if ( !isset($_POST['location_name']) || trim($_POST['location_name']) == ''
		|| !isset($_POST['company_name']) || trim($_POST['company_name']) == ''
		|| !isset($_POST['role_title']) || trim($_POST['role_title']) == ''
		|| !isset($_POST['open_yesno']) || trim($_POST['open_yesno']) == ''
		|| ($_POST['location_name'] == "Other" && (!isset($_POST['location_name_other']) || trim($_POST['location_name_other']) == '' ))
		|| ($_POST['role_title'] == "Other" && (!isset($_POST['role_title_other']) || trim($_POST['role_title_other']) == '') )  
		) {
		$error = "Please fill out all required fields.";
	} else {

		$mysqli = new mysqli(host, user, pass, db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$bool_loc_other = FALSE;
	    $bool_role_other = FALSE;

		$location_name = $_POST['location_name'];
		if($location_name == "Other"){
			$location_name = $_POST['location_name_other'];
			$bool_loc_other = TRUE;

		}else if ($location_name != "Other" && $location_name != NULL){
			$location_name = $_POST['location_name'];
		
		}

		$company_name = $_POST['company_name'];

		$role_title = $_POST['role_title'];
		if($role_title == "Other"){
			$role_title = $_POST['role_title_other'];
			$bool_role_other = TRUE;
		}else if ($role_title != "Other" && $role_title != NULL){
			$role_title = $_POST['role_title'];
		}

		$open_yesno = $_POST['open_yesno'];
		
		$sql = "DELETE FROM internship_table 
                WHERE company = '$company_name' and location=$location_name and role=$role_title and open=$open_yesno;";


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
	<title>Delete Confirmation</title>
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="delete_internship.php">Delete</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1>Delete an Internship</h1>
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
						<span class="font-italic">If found in the database, <?php echo $company_name; ?></span> was successfully deleted.
					</div>

				<?php endif; ?>

			</div> 
		</div> 
		<div>
			<div class="back">
				<a href="delete_internship.php" role="button" class="btn btn-primary"><< Back</a>
			</div> 
		</div> 
	</div> 
</body>
</html>