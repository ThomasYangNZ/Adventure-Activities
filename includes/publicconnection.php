<?php
	/*  Connect to the database with the public user */
	/*$dbc = mysqli_connect("localhost", "yangth_Public", 'N~%[aNV;(znkM4+R', "yangth_AssessmentDb");*/
	/* Temporarily have a default root connection to simplify process for people who want to play around with the code */
	$dbc = mysqli_connect("localhost", "root", '', "yangth_AssessmentDb");
	if (!$dbc){
		echo "<h1>Error!</h1>";
		exit();
	} else {
	}
?>