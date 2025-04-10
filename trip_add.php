<?php 
	session_start();

	// create an if statement to check user is logged in
	if(!isset($_SESSION['UserType'])) {
		$_SESSION['Error'] = "Error! Unauthorized access!";
		header("Location: index.php");
		exit();
	} else {
		// Create an if state,ent to check if user is admin or trip leader
		if($_SESSION['UserType'] != "Admin" && $_SESSION['UserType'] != "Trip Leader") {
			$_SESSION['Error'] = "Error! Unauthorized access!";
			header("Location: index.php");
			exit();
		}
	}
	// Create a switch statement to change regarding the UserType
	switch($_SESSION['UserType']) {
		case "Admin":
			// connect to the database via admin connection
			include("includes/adminconnection.php");
			break;
		case "Trip Leader":
			// connect to the database via team leader connection
			include("includes/tripleaderconnection.php");
			break;
		default:
			// connect to the database via public connection (although this should not happen!)
			include("includes/publicconnection.php");
	}


	// store the title, description and div id and send to head.php
	$title = "Adventure Kayak | Add Trip";
	$description = "This is the Adventure Kayak webpage which allows you to add a trip to our numerous trips";
	$img = "trip-add-background";

	// create a require statement for head.php
	require("includes/head.php"); 

	// Create an SQL statement to get all the difficulties
	$difficulty_query = "SELECT `DifficultyId`, `Difficulty` FROM `Difficulties`";
	$difficulty_result = mysqli_query($dbc, $difficulty_query);

	// Creat an SQL statement to get all the values of trip leaders and admins
	$leader_query = "SELECT `UserFirstName`, `UserLastName`, `UserEmail`, `UserId`, `PermissionType`
					FROM `Users`, `Permissions`
					WHERE `Permissions`.`PermissionId`=`Users`.`PermissionId`
					AND (`Users`.`PermissionId`=1
    					OR `Users`.`PermissionId`=3)";
	$leader_result = mysqli_query($dbc, $leader_query);
?>
<!-- div class content starts here -->
<div class="content">
<?php
	// If error is found
	if(isset($_SESSION['Error'])){
	
		$Error = $_SESSION['Error'];
		// Inform the user of the error
		echo "<p class='error'>$Error</p>";
		unset($_SESSION['Error']);
		unset($Error);
		
		// Store session variables in variables for clarity

		$TripName = $_SESSION['TripName'];
		$Days = $_SESSION['Days'];
		$MaxPeople = $_SESSION['MaxPeople'];
		$Price = $_SESSION['Price'];
		$DifficultyId = $_SESSION['Difficulty'];
		$Date = $_SESSION['Date'];
		$Trip_leader = $_SESSION['TripLeader'];

		// Display the form with previously entered data
		echo sprintf('<form name="add_trip" method="post" action="process_edits.php">
			Trip Name:	<input type="text" name="TripName" value="%s"><br>
			Days:	<input type="text" name="Days" value="%d"><br>
			Max People:	<input type="text" name="MaxPeople" value="%d"><br>
			Price:	<input type="text" name="Price" value="%.2f"><br>
			Difficulty
			<select name="difficulties">', $TripName, $Days, $MaxPeople, $Price);
			while($all_difficulties = mysqli_fetch_assoc($difficulty_result)){
				if($all_difficulties["DifficultyId"] == $DifficultyId){
					echo '<option value='.$all_difficulties["DifficultyId"].' selected>'.$all_difficulties["Difficulty"].'</option>';
				} else {
					echo '<option value='.$all_difficulties["DifficultyId"].'>'.$all_difficulties["Difficulty"].'</option>';
				}
				
			}
		echo sprintf('</select><br>
			Date: <input type="date" name="Date" value="%s"><br>
			Trip Leader:
			<select name="trip_leader">', $Date);
			while($all_trip_leaders = mysqli_fetch_assoc($leader_result)){
				if($all_trip_leaders["UserId"] == $Trip_leader){
					echo '<option value='.$all_trip_leaders["UserId"].' selected>'.$all_trip_leaders["UserFirstName"].' '.$all_trip_leaders["UserLastName"].'</option>';
				} else {
					echo '<option value='.$all_trip_leaders["UserId"].'>'.$all_trip_leaders["UserFirstName"].' '.$all_trip_leaders["UserLastName"].'</option>';
				}
			}
		echo '</select><br>';
		echo '<input type="submit" name="submit" value="Add new trip">		
			</form>';
		
		// So we don't retain the error and the older info
		unset($_SESSION['TripName']);
		unset($_SESSION['Days']);
		unset($_SESSION['MaxPeople']);
		unset($_SESSION['Street']);
		unset($_SESSION['Price']);
		unset($_SESSION['Difficulty']);
		unset($_SESSION['Date']);
		unset($_SESSION['TripLeader']);
		
	// If there are no errors, echo an empty form
	} else {
		echo '<form name="add_trip" method="post" action="process_edits.php">
			Trip Name:	<input type="text" name="TripName" value=""><br>
			Days:	<input type="text" name="Days" value=""><br>
			Max People:	<input type="text" name="MaxPeople" value=""><br>
			Price:	<input type="text" name="Price" value=""><br>
			Difficulty
			<select name="difficulties">';
			while($all_difficulties = mysqli_fetch_assoc($difficulty_result)){
				echo '<option value='.$all_difficulties["DifficultyId"].'>'.$all_difficulties["Difficulty"].'</option>';
			}
		echo '</select><br>
			Date: <input type="date" name="Date" value=""><br>
			Trip Leader:
			<select name="trip_leader">';
			while($all_trip_leaders = mysqli_fetch_assoc($leader_result)){
				echo '<option value='.$all_trip_leaders["UserId"].'>'.$all_trip_leaders["UserFirstName"].' '.$all_trip_leaders["UserLastName"].'</option>';
			}
		echo '</select><br>';

		echo '<input type="submit" name="submit" value="Add new trip">		
			</form>';
		
	}
?>
</div>
<!-- div class content ends here -->
<?php
	// require the file footer.php containing the website footer
	require("includes/footer.php");
?>