<?php
	/* Connect to database using a member connection */
	/*$dbc = mysqli_connect("localhost", "yangth_Member", 'pkA,#P!taH63;jMN', "yangth_AssessmentDb");*/
	/* Temporarily have a default root connection to simplify process for people who want to play around with the code */
	$dbc = mysqli_connect("localhost", "root", '', "yangth_AssessmentDb");
	if (!$dbc){
		echo "<h1>Error!</h1>";
		exit();
	} else {
	}

?>