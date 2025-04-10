<?php
	session_start();
	
	// If user is logged in, set variable and return to index page
	if(isset($_SESSION['UserType'])){
		$_SESSION['LogoutMessage'] = "You have been logged out!";
		// Unset user login
		unset($_SESSION['UserType']);
		header("Location: index.php");
		exit();
	// If user is not logged in, inform the user and return to index page
	} else {
		$_SESSION['LogoutMessageError'] = "You are currently not logged in!";
		header("Location: index.php");
		exit();
	}
?>