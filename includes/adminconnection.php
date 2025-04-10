<?php
	/*  Connect to the database with the admin user */
	$dbc = mysqli_connect("localhost", "yangth_Admin", 'Ks>z%rjf7<*%4eC!', "yangth_AssessmentDb");
	if (!$dbc){
		echo "<h1>Error!</h1>";
		exit();
	} else {
	}
?>