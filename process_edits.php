<?php
	session_start();

	// Switch the connection statement based off user type
	switch($_SESSION['UserType']) {
		case "Admin":
			// connect to the database via admin connection
			include("includes/adminconnection.php");
			break;
		case "Member":
			// connect to the database via member connection
			include("includes/memberconnection.php");
			break;
		case "Trip Leader":
			// connect to the database via team leader connection
			include("includes/tripleaderconnection.php");
			break;
		default:
			// connect to the database via public connection
			include("includes/publicconnection.php");
			break;
		}

	// Check for unauthorized access to the process_edits page
	if(!isset($_POST['submit'])){
		$_SESSION['Error'] = "Warning! Unauthorized access!";
		header("Location: index.php");
		exit();
	}

	// Execute the following sql and php if from log in submit button
	if($_POST['submit'] == "Log In"){

		// sanitize input
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		// create a more secure prepared statement
		$user_query = "SELECT `UserName`, `PasswordHash` FROM `users` WHERE `UserName` = ?";
		$user_stmt = mysqli_prepare($dbc, $user_query);
		mysqli_stmt_bind_param($user_stmt, "s", $username);
		mysqli_stmt_execute($user_stmt);
		$user_result = mysqli_stmt_get_result($user_stmt);
		$user_rows = mysqli_num_rows($user_result);

		// check if there are any results from the query if not, send user back to login page
		if($user_rows == 0) {
			$_SESSION['LoginMessage'] = "Credentials are incorrect!";
			// Close SQL statements
			mysqli_stmt_close($user_stmt);
			header("Location: login.php");
			exit();
		}

		// Verify the password hash
		$user_record = $user_result->fetch_assoc();
		$verify = password_verify($password, $user_record['PasswordHash']);


		// If correct, save user login and save details
		if($verify) {
			// create a query to save the permission type of the logged in user
			$permission_query = "SELECT `UserId`, `UserName`, `PermissionType`
								 FROM `users` 
								 JOIN `permissions` ON `users`.`PermissionId` = `permissions`.`PermissionId`
								 WHERE `users`.`UserName` = ?";
			$permission_stmt = mysqli_prepare($dbc, $permission_query);
			mysqli_stmt_bind_param($permission_stmt, "s", $username);
			mysqli_stmt_execute($permission_stmt);
			$permission_result = mysqli_stmt_get_result($permission_stmt);
			
			// Create a while loop to store user details in sessions
			while($user_permission = $permission_result->fetch_assoc()){
				$_SESSION['UserType'] = $user_permission['PermissionType'];
				$_SESSION['UserId'] = $user_permission['UserId'];
			}
			// Close SQL statements
			mysqli_stmt_close($user_stmt);
			mysqli_stmt_close($permission_stmt);
			header("Location: index.php");
			exit();

		// If incorrect, inform user and return to login page
		} else {
			$_SESSION['LoginMessage'] = "Credentials are incorrect!";
			// Close SQL statements
			mysqli_stmt_close($user_stmt);
			header("Location: login.php");
			exit();
		}
	// Execute the following sql and php if from new trip submit button
	} elseif($_POST['submit'] == "Add new trip"){
		
		// sanitize input
		$TripName = trim($_POST['TripName']);
		$Days = trim($_POST['Days']);	
		$MaxPeople = trim($_POST['MaxPeople']);
		$Price = trim($_POST['Price']);
		$DifficultyId = trim($_POST['difficulties']);
		$Date = trim($_POST['Date']);
		$LeaderId = trim($_POST['trip_leader']);
		
		// Save user input in sessions (This is so we can repopulate correctly inputted values and only reset the bad ones!)
		$_SESSION['TripName'] = $TripName;
		$_SESSION['Days'] = $Days;
		$_SESSION['MaxPeople'] = $MaxPeople;
		$_SESSION['Price'] = $Price;
		$_SESSION['Difficulty'] = $DifficultyId;
		$_SESSION['Date'] = $Date;
		$_SESSION['TripLeader'] = $LeaderId;
		
		// Create a variable which saves the current live date
		$now = new DateTime();
		$date_query = new DateTime($Date);
		$errors = 0;

		// Check our data meets the requirements 
		if(strlen($TripName) <= 0 || strlen($TripName) > 20){
			$errors = 1;
			$_SESSION['Error'] = "There is an error with the length of your trip name - this field is required and the maximum field size is 20 characters.";
			$_SESSION['TripName'] = "";
		} elseif($Days <= 0 || $Days > 255){
			$errors = 1;
			$_SESSION['Error'] = "There is an error with the amount of days - this field is required and the maximum field size is 255 characters.";
			$_SESSION['Days'] = "";
		} elseif($MaxPeople <= 0 || $MaxPeople > 255){
			$errors = 1;
			$_SESSION['Error'] = "There is an error with the amount of maximum people - this field is required and the maximum field size is 255 characters.";
			$_SESSION['MaxPeople'] = "";
		} elseif($Price <= 0 || $Price > 999.99){
			$errors = 1;
			$_SESSION['Error'] = "There is an error with the amount of your price - this field is required and the maximum field size is 999.99 characters.";
			$_SESSION['Price'] = "";
		} elseif($date_query < $now){
			$errors = 1;
			$_SESSION['Error'] = "This date has already passed!";
			$_SESSION['Date'] = "";
		}

		// Jump back to the trip add page if we have encountered an error
		if($errors > 0) {
			header("Location: trip_add.php"); 
			exit();
		} else {
	        // create a query to save the trip type (this differs from the actual trip conducted)
	        $add_trip_type_query = "INSERT INTO triptypes (TripName, Days, MaxPeople, Price, DifficultyId) VALUES (?, ?, ?, ?, ?)";
	        $add_trip_type_stmt = mysqli_prepare($dbc, $add_trip_type_query);
	        mysqli_stmt_bind_param($add_trip_type_stmt, "siiid", $TripName, $Days, $MaxPeople, $Price, $DifficultyId);
	        $add_trip_type_result = mysqli_stmt_execute($add_trip_type_stmt);

	        // Get the last inserted trip type ID
	        if ($add_trip_type_result) {
	            $new_triptypeid = mysqli_insert_id($dbc);
	        } else {
	            $_SESSION['Error'] = "Failure to insert a new trip type";
	            mysqli_stmt_close($add_trip_type_stmt);
				header("Location: trip_add.php"); 
				exit();
	        }

	        // create a query to save the new trip which uses the new trip type's id
	        $add_trip_query = "INSERT INTO trips (TripTypeId, UserId, Date) VALUES (?, ?, ?)";
	        $add_trip_stmt = mysqli_prepare($dbc, $add_trip_query);
	        mysqli_stmt_bind_param($add_trip_stmt, "iis", $new_triptypeid, $LeaderId, $Date);
	        $add_trip_result = mysqli_stmt_execute($add_trip_stmt);

	        // Check if the results were submitted into the database
	        if ($add_trip_result) {
	            $_SESSION['AddTrip'] = "Trip added successfully!";
	            // Close SQL statements
	            mysqli_stmt_close($add_trip_type_stmt);
	            mysqli_stmt_close($add_trip_stmt);
	            header("Location: trip_add.php");
	            exit();
	        } else {
	        	// Close SQL statements
	            mysqli_stmt_close($add_trip_type_stmt);
	            mysqli_stmt_close($add_trip_stmt);
	            $_SESSION['Error'] = "Failure to insert a new trip";
				header("Location: trip_add.php"); 
				exit();
	        }
	    }
	// Execute the following sql and php if from join now submit button 
	} elseif($_POST['submit'] == "Join Now!"){
		// Santize input
		$trip_id = trim($_POST['trip_id']);
		
		// Call all the user details 
		$user_details_query = "SELECT `UserFirstName`, `UserLastName`, `UserEmail` FROM `users` WHERE `UserId`= ?";
		$user_details_stmt = mysqli_prepare($dbc, $user_details_query);
		mysqli_stmt_bind_param($user_details_stmt, "i", $_SESSION['UserId']);
		mysqli_stmt_execute($user_details_stmt);

		$user_results = mysqli_stmt_get_result($user_details_stmt);
		// Retreieve and store the user's results
		while($user_rows=mysqli_fetch_assoc($user_results)) {
			$UserFirstName = $user_rows['UserFirstName'];
			$UserLastName = $user_rows['UserLastName'];
			$UserEmail = $user_rows['UserEmail'];
		}

		// Create a secured sql statement
		$membertrip_query = "INSERT INTO MemberTrips (MemberFirstName, MemberLastName, MemberEmail, TripId) VALUES (?, ?, ?, ?)";
		$membertrip_stmt = mysqli_prepare($dbc, $membertrip_query);
		mysqli_stmt_bind_param($membertrip_stmt, "sssi", $UserFirstName, $UserLastName, $UserEmail, $trip_id);

		// Execute and check if the results were submitted into the database
		if(mysqli_stmt_execute($membertrip_stmt)){
	        // Close SQL statements
	        mysqli_stmt_close($user_details_stmt);
	        mysqli_stmt_close($membertrip_stmt);
			$_SESSION['AddMember'] = "You have joined successful!";
			header("Location: index.php");
			exit();
		} else {
	        // Close SQL statements
	        mysqli_stmt_close($user_details_stmt);
	        mysqli_stmt_close($membertrip_stmt);
	        $_SESSION['Error'] = "Failure to sign up";
			header("Location: trip_add.php"); 
			exit();
		}
	// Execute the following sql and php if from update trip submit button
	} elseif($_POST['submit'] == "Update Trip"){
		
		//sanitize input
		$update_date = trim($_POST['Date']);
		$update_leader = trim($_POST['new_leader']);
		$update_trip = trim($_POST['UpdateTripId']);
		
		// Save inputted data in sessions (This is so we can repopulate correctly inputted values and only reset the bad ones!)
		$_SESSION['Update_Date'] = $update_date;
		$_SESSION['Update_UserId'] = $update_leader;
		
		// Create a variable which saves the current live date
		$now = new DateTime();
		$new_date = new DateTime($update_date);
		$errors = 0;
		// Create an of if statement to validate user input
		if($new_date < $now){
			$errors = 1;
			$_SESSION['Error'] = "This date has already passed!";
			$_SESSION['Update_Date'] = "";
		}
		// Jump back if we have encoutered an error
		if($errors==1) {
			header("Location: index.php");
			exit();
		}
		// Create a more secure SQL statement to update the trip details
		$update_trip_query = "UPDATE `Trips` SET `UserId` = ?, `Date` = ? WHERE `TripId` = ?";
		$update_trip_stmt = mysqli_prepare($dbc, $update_trip_query);
		mysqli_stmt_bind_param($update_trip_stmt, "ssi", $update_leader, $update_date, $update_trip);

		// Execute and check if the results were submitted into the database 
		if(mysqli_stmt_execute($update_trip_stmt)){
	        // Close SQL statements
	        mysqli_stmt_close($update_trip_stmt);
			header("Location: index.php");
			exit();
		} else {
	        // Close SQL statements
	        mysqli_stmt_close($update_trip_stmt);
	        $_SESSION['Error'] = "Failure to update trip";
			header("Location: trip_add.php"); 
			exit();
		}

	// Execute the following sql and php if from delete trip submit button
	} elseif($_POST['submit'] == "Delete Trip") {
		// Santize input
		$trip_id = trim($_POST['trip_id']);

		// Locate the trip to be deleted
		$delete_trip_query = "DELETE FROM trips WHERE TripId = ?";
		$delete_stmt = mysqli_prepare($dbc, $delete_trip_query);
		mysqli_stmt_bind_param($delete_stmt, "i", $trip_id);

		// Execute and check if the deletion was successful
		if(mysqli_stmt_execute($delete_stmt)) {
	        // Close SQL statements
	        mysqli_stmt_close($delete_stmt);
			header("Location: trips.php");
			exit();
		} else {
	        // Close SQL statements
	        mysqli_stmt_close($delete_stmt);
	        $_SESSION['Error'] = "Failure to delete trip";
			header("Location: index.php"); 
			exit();
		}
	} elseif($_POST['submit'] == "Update Trip Type") {

		// Santize input
		$new_triptypeid = trim($_POST['trip_type_id']);
		$trip_id = trim($_POST['trip_id']);
		
		// Create a more secure SQL statement to update the trip details
		$update_trip_type_query = "UPDATE `trips` SET `TripTypeId` = ? WHERE `TripId` = ?";
		$update_type_stmt = mysqli_prepare($dbc, $update_trip_type_query);
		mysqli_stmt_bind_param($update_type_stmt, "ii", $new_triptypeid, $trip_id);
        // Execute the statement
        if (mysqli_stmt_execute($update_type_stmt)) {
	        // Close SQL statements
	        mysqli_stmt_close($update_type_stmt);
            header("Location: index.php");
            exit();
        } else {
	        // Close SQL statements
	        mysqli_stmt_close($update_type_stmt);
	        $_SESSION['Error'] = "Failure to update trip type";
			header("Location: index.php"); 
			exit();
        }
	}
?>
