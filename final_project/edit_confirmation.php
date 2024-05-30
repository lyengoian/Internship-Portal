<?php

	if ( !isset($_POST['location_name']) || trim($_POST['location_name']) == ''
		|| !isset($_POST['company_name']) || trim($_POST['company_name']) == ''
		|| !isset($_POST['role_title']) || trim($_POST['role_title']) == ''
		|| !isset($_POST['open_yesno']) || trim($_POST['open_yesno']) == ''
		) {
		$error = "Please fill out all required fields!";
	} else {

		require 'config/config.php';

		$mysqli = new mysqli(host, user, pass, db);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}


		$location_name = $_POST['location_name'];
	
		$company_name = $_POST['company_name'];

		$role_title = $_POST['role_title'];
	
		$open_yesno = $_POST['open_yesno'];
		
		$sql_int_id = "SELECT * FROM internship_table;";
		if ($result = mysqli_query($mysqli, $sql_int_id)) {
			$rowcount = mysqli_num_rows( $result );
		}
		$int_id = $rowcount + 1;

		$sql_location_id = "SELECT * FROM location_table;";
		if ($result = mysqli_query($mysqli, $sql_location_id)) {
			$rowcount = mysqli_num_rows( $result );
		}
		$location_id = $rowcount + 1;

		$sql_role_title_id = "SELECT * FROM role_table;";
		if ($result = mysqli_query($mysqli, $sql_role_title_id)) {
			$rowcount = mysqli_num_rows( $result );
		}

		$sql = "UPDATE internship_table 
                SET open=$open_yesno
				WHERE company = '$company_name' and location=$location_name and role=$role_title;";

		$results = $mysqli->query($sql);

		if (!$results) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
        if($open_yesno == 1){
            $open_yesno = "'open'";
        }
        else{
            $open_yesno = "'closed'";
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

	<title>Edit Confirmation</title>
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="edit_internship.php">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1>Edit an Internship</h1>
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
						<span class="font-italic">If found in the database, <?php echo $company_name; ?></span>'s status was successfully changed to <?php echo $open_yesno; ?>.
					</div>

				<?php endif; ?>

			</div> 
		</div> 
		<div>
			<div class="back">
				<a href="edit_internship.php" role="button" class="btn btn-primary"><< Back</a>
			</div> 
		</div> 
	</div> 
</body>
</html>