<?php
	/*  Connect to the database with the public user */
	$dbc = mysqli_connect("localhost", "yangth_Public", 'N~%[aNV;(znkM4+R', "yangth_AssessmentDb");
	if (!$dbc){
		echo "<h1>Error!</h1>";
		exit();
	} else {
	}
?>